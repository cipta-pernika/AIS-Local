const mqtt = require('mqtt');
const { MongoClient } = require('mongodb');
const sbs1 = require('sbs1');

// Initialize clients/connections
const mongoClient = new MongoClient('mongodb://localhost:27017');
const mqttClient = mqtt.connect('mqtt://mqtt.cakrawala.id:1883', {
  clientId: 'adsb_decoder' 
});

// MQTT setup
mqttClient.on('connect', () => {
  mqttClient.subscribe('adsbrawfak', (err) => {
    if (err) console.error('MQTT subscription error:', err);
  });
});

// Cache MongoDB connection
let mongoDb;
let bulkOps = [];
const BULK_SIZE = 100;
let bulkTimer = null;
const BULK_TIMEOUT = 5000; // 5 seconds

// Initialize MongoDB connection
async function getMongoDb() {
    if (!mongoDb) {
        await mongoClient.connect();
        mongoDb = mongoClient.db('adsbData');
    }
    return mongoDb;
}

// Execute bulk operations
async function executeBulkOps() {
    if (bulkOps.length === 0) return;
    
    try {
        const db = await getMongoDb();
        await db.collection('aircraft').bulkWrite(bulkOps, { ordered: false });
        bulkOps = [];
    } catch (error) {
        console.error('Bulk write error:', error);
        if (!mongoClient.topology?.isConnected()) {
            await initializeMongoDB();
        }
    } finally {
        bulkTimer = null;
    }
}

// MongoDB initialization
async function initializeMongoDB() {
  try {
    await mongoClient.connect();
    const db = mongoClient.db('adsbData');
    
    // Create aircraft collection if not exists
    const collections = await db.listCollections({name: 'aircraft'}).toArray();
    if (collections.length === 0) {
      await db.createCollection('aircraft', {
        timeseries: {
          timeField: 'timestamp',
          metaField: 'icao',
          granularity: 'minutes'
        },
        expireAfterSeconds: 3600 // 1 hour
      });
      
      await db.collection('aircraft').createIndex(
        { icao: 1, timestamp: -1 },
        { background: true }
      );
    }
  } catch (error) {
    console.error('MongoDB init error:', error);
  }
}

// Process and save ADSB data
async function processADSBData(message) {
  try {
    // Extract relevant data
    const icao = message.hex_ident || message.hex;
    if (!icao) return;
    
    // Only proceed if we have position data
    if (!(message.lat && message.lon)) return;
    
    // Combine all data into one document
    const aircraftData = {
      timestamp: new Date(),
      icao,
      callsign: message.callsign?.trim() || message.flight?.trim(),
      category: message.category,
      registration: message.registration,
      squawk: message.squawk,
      type: message.type,
      position: {
        latitude: message.lat,
        longitude: message.lon
      },
      altitude: message.altitude,
      speed: message.ground_speed || message.speed,
      track: message.track,
      vertical_rate: message.vertical_rate,
      emergency: message.emergency,
      rssi: message.rssi,
      is_on_ground: message.is_on_ground
    };

    // Add to bulk operations instead of immediate insert
    bulkOps.push({ insertOne: { document: aircraftData } });
    
    // Execute bulk operations if we've reached the threshold
    if (bulkOps.length >= BULK_SIZE) {
      await executeBulkOps();
    } else if (!bulkTimer) {
      // Set a timer to execute remaining operations after timeout
      bulkTimer = setTimeout(executeBulkOps, BULK_TIMEOUT);
    }
  } catch (error) {
    console.error('Error processing ADSB data:', error);
    if (!mongoClient.topology?.isConnected()) {
      await initializeMongoDB();
    }
  }
}

mqttClient.on('message', async (topic, message) => {
  try {
    const messageStr = message.toString().trim();
    if (!messageStr) return;
    
    // Parse SBS1 format message
    const parsedMessage = sbs1.parseSbs1Message(messageStr);
    if (parsedMessage) {
      await processADSBData(parsedMessage);
    }
  } catch (error) {
    console.error('Message processing error:', error);
  }
});

mqttClient.on('error', (err) => {
  console.error('MQTT error:', err);
});

// Initialize MongoDB on startup
initializeMongoDB();

// Clean up on process exit
process.on('SIGINT', async () => {
  if (bulkOps.length > 0) {
    console.log('Flushing remaining operations before exit...');
    await executeBulkOps();
  }
  await mongoClient.close();
  mqttClient.end();
  process.exit(0);
});
