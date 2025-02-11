import pyModeS as pms
from pyModeS.extra.tcpclient import TcpClient

class ADSBClient(TcpClient):
    def __init__(self, host, port, rawtype):
        super(ADSBClient, self).__init__(host, port, rawtype)

    def handle_messages(self, messages):
        even_frame = None
        odd_frame = None

        for msg, ts in messages:
            if len(msg) != 28:  # wrong data length
                continue

            df = pms.df(msg)

            if df != 17:  # not ADSB
                continue

            if pms.crc(msg) != 0:  # CRC fail
                continue

            icao = pms.adsb.icao(msg)
            tc = pms.adsb.typecode(msg)

            # Decode additional fields
            callsign = None
            position = None
            altitude = None
            velocity = None

            if tc in [5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 20, 21, 22]:
                # For surface, airborne barometric, and airborne GNSS positions
                if tc in [5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18]:
                    if even_frame is None:
                        even_frame = msg
                    else:
                        odd_frame = msg

                    if even_frame and odd_frame:
                        t_even = 0  # Replace with the actual timestamp for the even message
                        t_odd = 0  # Replace with the actual timestamp for the odd message
                        position = pms.adsb.position(even_frame, odd_frame, t_even, t_odd)
                        altitude = pms.adsb.altitude(msg)

                        # Reset even and odd frames
                        even_frame = None
                        odd_frame = None
            elif tc == 19:
                # Velocity information
                velocity = pms.adsb.velocity(msg)
            elif tc in [20, 21]:
                # Identification message
                callsign = pms.adsb.callsign(msg)

            # Print message information
            print("Timestamp:", ts)
            print("ICAO Address:", icao)
            print("Type Code:", tc)
            print("Callsign:", callsign)
            print("Position:", position)
            print("Altitude:", altitude)
            print("Velocity:", velocity)
            print()

# Create an instance of the ADSBClient and run it
client = ADSBClient(host='192.168.100.2', port=32457, rawtype='beast')
client.run()
