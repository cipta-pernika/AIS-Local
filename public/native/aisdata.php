<?php

// Replace Laravel-specific code with native PHP code

$requestBody = file_get_contents("php://input");

// Parse the JSON payload
$requestData = json_decode($requestBody, true);

if (empty($requestData['source'])) {
    http_response_code(400);
    echo json_encode(['error' => 'No request payload provided.']);
    exit;
}

// Replace database connection with your own
$mysqli = new mysqli('127.0.0.1', 'opadmin', '@opADM1N!!!!', 'fleem10_trackdb_2');
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: " . $mysqli->connect_error;
    exit();
}

// Define the findSensor function
function findSensor($mysqli, $id) {
    // Implement the findSensor function
}

// Define the saveSensorData function
function saveSensorData($mysqli, $sensorData) {
    // Implement the saveSensorData function
}

$sensor = findSensor($mysqli, 1);

$sensorData = new stdClass(); // Define the SensorData class
$sensorData->sensor_id = $sensor['id'];
$sensorData->payload = $_REQUEST['source'];
$sensorData->timestamp = date('Y-m-d H:i:s', strtotime($_REQUEST['isoDate']));
saveSensorData($mysqli, $sensorData);

$vesselPosition = null;

if (isset($_REQUEST['mmsi'])) {
    // Define the updateOrCreateAisDataVessel function
    function updateOrCreateAisDataVessel($mysqli, $mmsi, $data = []) {
        // Implement the updateOrCreateAisDataVessel function
    }

    // Define the createEventTracking function
    function createEventTracking($mysqli, $eventType, $mmsi, $name = null) {
        // Implement the createEventTracking function
    }

    // Define the isValidLatitude function
    function isValidLatitude($latitude) {
        // Implement the isValidLatitude function
    }

    // Define the isValidLongitude function
    function isValidLongitude($longitude) {
        // Implement the isValidLongitude function
    }

    // Define the findDatalogger function
    function findDatalogger($mysqli, $id) {
        // Implement the findDatalogger function
    }

    $vessel = updateOrCreateAisDataVessel($mysqli, $_REQUEST['mmsi']);
    if (isset($vessel->wasRecentlyCreated) && $vessel->wasRecentlyCreated) {
        createEventTracking($mysqli, 6, $_REQUEST['mmsi']);
    }

    $latitude = $_REQUEST['latitude'];
    $longitude = $_REQUEST['longitude'];
    if (isValidLatitude($latitude) && isValidLongitude($longitude)) {
        $datalogger = findDatalogger($mysqli, 1);
        // Define the Coordinate and Haversine classes
        class Coordinate {
            public $latitude;
            public $longitude;
        }

        class Haversine {
            public function getDistance($coord1, $coord2) {
                // Implement the Haversine formula to calculate distance
            }
        }

        $coordinate1 = new Coordinate();
        $coordinate1->latitude = $datalogger['latitude'];
        $coordinate1->longitude = $datalogger['longitude'];
        $coordinate2 = new Coordinate();
        $coordinate2->latitude = $latitude;
        $coordinate2->longitude = $longitude;
        $distance = (new Haversine())->getDistance($coordinate1, $coordinate2);
        $distanceInKilometers = $distance / 1000;
        $distanceInNauticalMiles = $distanceInKilometers * 0.539957;

        // Define the AisDataPosition class
        class AisDataPosition {
            public $sensor_data_id;
            public $vessel_id;
            public $latitude;
            public $longitude;
            public $speed;
            public $course;
            public $heading;
            public $navigation_status;
            public $turning_rate;
            public $turning_direction;
            public $timestamp;
            public $distance;
        }

        // Define the saveAisDataPosition function
        function saveAisDataPosition($mysqli, $vesselPosition) {
            // Implement the saveAisDataPosition function
        }

        $vesselPosition = new AisDataPosition();
        $vesselPosition->sensor_data_id = $sensorData->id;
        $vesselPosition->vessel_id = $vessel->id;
        $vesselPosition->latitude = $latitude;
        $vesselPosition->longitude = $longitude;
        $vesselPosition->speed = $_REQUEST['speedOverGround'];
        $vesselPosition->course = $_REQUEST['courseOverGround'];
        $vesselPosition->heading = $_REQUEST['trueHeading'];
        $vesselPosition->navigation_status = $_REQUEST['navigationStatus'];
        $vesselPosition->turning_rate = $_REQUEST['turningRate'] ?? $_REQUEST['rateOfTurn'];
        $vesselPosition->turning_direction = $_REQUEST['turningDirection'];
        $vesselPosition->timestamp = date('Y-m-d H:i:s', strtotime($_REQUEST['isoDate']));
        $vesselPosition->distance = $distanceInNauticalMiles;

        saveAisDataPosition($mysqli, $vesselPosition);
    }
} elseif (isset($_REQUEST['senderMmsi'])) {
    $vessel = updateOrCreateAisDataVessel($mysqli, $_REQUEST['senderMmsi'], [
        'vessel_name' => $_REQUEST['name'],
        'vessel_type' => $_REQUEST['shipType_text'],
        'imo' => $_REQUEST['shipId'],
        'callsign' => $_REQUEST['callsign'],
        'draught' => $_REQUEST['draught'],
        'reported_destination' => $_REQUEST['destination'],
        'dimension_to_bow' => $_REQUEST['dimensionToBow'],
        'dimension_to_stern' => $_REQUEST['dimensionToStern'],
        'dimension_to_port' => $_REQUEST['dimensionToPort'],
        'dimension_to_starboard' => $_REQUEST['dimensionToStarboard'],
        'reported_eta' => date('Y-m-d H:i:s', strtotime($_REQUEST['eta'])),
        'type_number' => $_REQUEST['type_number'],
    ]);
    if (isset($vessel->wasRecentlyCreated) && $vessel->wasRecentlyCreated) {
        createEventTracking($mysqli, 6, $_REQUEST['mmsi'], $_REQUEST['name']);
    }
}

$aisData = null;

if ($vesselPosition) {
    // Define the findAisDataPosition function
    function findAisDataPosition($mysqli, $id) {
        // Implement the findAisDataPosition function
    }

    $aisData = findAisDataPosition($mysqli, $vesselPosition->id);
}

// Replace response() with native PHP code to send JSON response
$response = [
    'aisData' => $aisData,
];

echo json_encode($response);
http_response_code(201);
