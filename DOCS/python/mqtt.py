import json
import http.client
import paho.mqtt.client as mqtt

# MQTT settings
mqtt_broker = "103.143.170.181"
mqtt_port = 1883
mqtt_topic = "aisdatastaticksop"

# HTTP settings
api_host = "lumensopbuntut.cakrawala.id"
api_path = "/api/aisdata"

# Function to send HTTP POST request
def send_post_request(payload):
    connection = http.client.HTTPSConnection(api_host)
    headers = {
        "Content-Type": "application/json",
        "Accept": "application/json",
        "User-Agent": "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36",
    }

    try:
        # Print the payload before sending the request
        print("Sending payload to HTTP:", payload)

        # Send HTTP POST request using http.client
        connection.request("POST", api_path, body=json.dumps(payload), headers=headers)
        response = connection.getresponse()

        # Print the response from the server
        print("HTTP Response:", response.status, response.reason)
        print(response.read().decode("utf-8"))

    except Exception as e:
        print("Error sending HTTP request:", e)

    finally:
        connection.close()

# MQTT callback when a message is received
def on_message(client, userdata, msg):
    try:
        # Ensure the payload is a valid JSON
        json_data = json.loads(msg.payload.decode("utf-8"))

        # Print the JSON data received from MQTT
        print("Received JSON data from MQTT:", json_data)

        # Call the function to send the HTTP POST request
        send_post_request(json_data)

    except Exception as e:
        print("Error processing MQTT message:", e)

# Create MQTT client
mqtt_client = mqtt.Client()
mqtt_client.on_message = on_message

# Connect to the MQTT broker
mqtt_client.connect(mqtt_broker, mqtt_port, 60)
mqtt_client.subscribe(mqtt_topic)

# Loop to keep the script running
mqtt_client.loop_forever()
