from pyais.stream import TCPConnection
import paho.mqtt.client as mqtt

host = '192.168.8.1'
port = 5000

mqtt_host = 'mqtt.cakrawala.id'
mqtt_port = 1883
mqtt_topic = 'aispybadak'

client = mqtt.Client(protocol=mqtt.MQTTv5)
client.connect(mqtt_host, mqtt_port, 60)

for msg in TCPConnection(host, port=port):
    decoded_message = msg.decode()
    ais_content = decoded_message

    print('*' * 80)
    if msg.tag_block:
        # decode & print the tag block if it is available
        msg.tag_block.init()
        print(msg.tag_block.asdict())

    print(ais_content)
    client.publish(mqtt_topic, str(ais_content))