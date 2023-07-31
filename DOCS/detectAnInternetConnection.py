import socket
import time
import requests  # or import urllib3

def is_internet_available(url="http://www.google.com"):
    try:
        # Use requests library to check internet connection
        response = requests.get(url)
        return response.status_code == 200
    except:
        return False

    # Alternatively, you can use urllib3 to check internet connection
    # http = urllib3.PoolManager()
    # try:
    #     response = http.request("GET", url)
    #     return response.status == 200
    # except:
    #     return False

def tcp_out_server(host, port):
    # Create a TCP/IP socket
    tcp_socket = socket.socket(socket.AF_INET, socket.SOCK_STREAM)

    # Bind the socket to the port
    server_address = (host, port)
    tcp_socket.bind(server_address)

    # Listen for incoming connections
    tcp_socket.listen(1)

    print("Waiting for a connection...")

    while True:
        # Wait for a connection
        connection, client_address = tcp_socket.accept()
        try:
            print("Connection established with:", client_address)

            # Send some data over the connection
            message = "Hello from the server!"
            connection.sendall(message.encode())

        finally:
            # Clean up the connection
            connection.close()

if __name__ == "__main__":
    # Replace "www.google.com" with the URL of the website you want to check
    while not is_internet_available("http://www.google.com"):
        print("Internet connection not available. Retrying in 5 seconds...")
        time.sleep(5)

    # Internet connection is available, trigger TCP communication
    host = "localhost"  # Change this to your desired host
    port = 12345        # Change this to your desired port
    tcp_out_server(host, port)
