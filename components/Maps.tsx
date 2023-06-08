import React, { useEffect, useState } from 'react';
import { MapContainer, TileLayer, Marker, Popup } from "react-leaflet";
// import "leaflet/dist/leaflet.css";
import "leaflet/dist/images/marker-shadow.png";
import "leaflet/dist/images/marker-icon.png";
import axios from 'axios';

const Maps = () => {

    const [aisData, setAisData] = useState([]);
    const [latitude, setLatitude] = useState(-6.155478172945876);
    const [longitude, setLongitude] = useState(106.83637314148093);
    const [filteredAisData, setFilteredAisData] = useState<any>([]);



    const fetchAisData = async () => {
        try {
            const response = await axios.get("http://localhost:8000/api/aisdataunique");
            if (response.data.success) {
                setAisData(response.data.message);
                setFilteredAisData(response.data.message);
                setLatitude(response.data.message[0]?.latitude);
                setLongitude(response.data.message[0]?.longitude);
            }
        } catch (error) {
            console.log({ error });
        }
    };

    useEffect(() => {

        fetchAisData();
    }, [])

    return (

        <MapContainer center={[latitude, longitude]} zoom={10}>
            <TileLayer
                attribution='&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                url="https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png"
            />
            {filteredAisData.map((ais: any) => (
                <Marker
                    key={ais.id}
                    position={[ais.latitude, ais.longitude]}
                >
                    <Popup>
                        <table className="table-auto">
                            <tbody>
                                <tr>
                                    <td className="font-bold">ID:</td>
                                    <td>{ais.id}</td>
                                </tr>
                                <tr>
                                    <td className="font-bold">
                                        Sensor Data ID:
                                    </td>
                                    <td>{ais.sensor_data_id}</td>
                                </tr>
                                <tr>
                                    <td className="font-bold">
                                        Vessel ID:
                                    </td>
                                    <td>{ais.vessel_id}</td>
                                </tr>
                                <tr>
                                    <td className="font-bold">Latitude:</td>
                                    <td>{ais.latitude}</td>
                                </tr>
                                <tr>
                                    <td className="font-bold">
                                        Longitude:
                                    </td>
                                    <td>{ais.longitude}</td>
                                </tr>
                                <tr>
                                    <td className="font-bold">Speed:</td>
                                    <td>{ais.speed}</td>
                                </tr>
                                <tr>
                                    <td className="font-bold">Course:</td>
                                    <td>{ais.course}</td>
                                </tr>
                                <tr>
                                    <td className="font-bold">Heading:</td>
                                    <td>{ais.heading}</td>
                                </tr>
                                <tr>
                                    <td className="font-bold">Status:</td>
                                    <td>{ais.status}</td>
                                </tr>
                                <tr>
                                    <td className="font-bold">
                                        Timestamp:
                                    </td>
                                    <td>{ais.timestamp}</td>
                                </tr>
                            </tbody>
                        </table>
                    </Popup>
                </Marker>
            ))}
        </MapContainer>
    );
};

export default Maps;
