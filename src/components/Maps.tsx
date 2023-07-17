import React, { FC, useEffect, useState } from 'react';
// eslint-disable-next-line import/no-extraneous-dependencies
import { useNavigate } from 'react-router';
import {
    MapContainer, Polyline, useMapEvents, useMap, Marker, ImageOverlay
} from 'react-leaflet';
import 'leaflet/dist/images/marker-shadow.png';
import 'leaflet/dist/images/marker-icon.png';
import axios from 'axios';
import '../styles/MapStyles.css';
import L from 'leaflet';
import { Box, Button, Drawer, Fab, FormControl, Grid, InputLabel, Link, MenuItem, Select, Stack, TextField, Typography } from '@mui/material';
import { toast } from 'react-toastify';
import dayjs from 'dayjs';
import utc from 'dayjs/plugin/utc';
import { isMobile } from 'react-device-detect';
import MarkerClusterGroup from 'react-leaflet-cluster';
import AddOutlinedIcon from '@mui/icons-material/AddOutlined';
import RemoveOutlinedIcon from '@mui/icons-material/RemoveOutlined';
import OpenInFullOutlinedIcon from '@mui/icons-material/OpenInFullOutlined';
import PersonPinCircleOutlinedIcon from '@mui/icons-material/PersonPinCircleOutlined';
import ChatOutlinedIcon from '@mui/icons-material/ChatOutlined';
import useGeolocation from 'react-hook-geolocation';
import Tooltip from '@mui/material/Tooltip';
import CloseOutlinedIcon from '@mui/icons-material/CloseOutlined';
import 'leaflet-draw'
import './measurepolygon/leaflet.MeasurePolygon'
import './measurepolygon/libs/editable'
import './measurepolygon/libs/leaflet-measure-path'
import './measurepolygon/libs/measure'
import './measurepolygon/libs/leaflet-measure-path.css'
import 'leaflet-draw/dist/leaflet.draw.css'
import LoadingButton from '@mui/lab/LoadingButton';
import { getGreatCircleBearing, getBoundsOfDistance } from 'geolib';
import VisibilityIcon from '@mui/icons-material/Visibility';
import VisibilityOffIcon from '@mui/icons-material/VisibilityOff';
import Tab from '@mui/material/Tab';
import TabContext from '@mui/lab/TabContext/TabContext';
import TabList from '@mui/lab/TabList/TabList';
import TabPanel from '@mui/lab/TabPanel/TabPanel';
import CenterFocusWeakIcon from '@mui/icons-material/CenterFocusWeak';
import LayerMap from '../pages/presentation/dashboard/LayerMap';
import kapalLaut from '../assets/img/KapalLaut.png';
import kapalIcon from '../assets/img/boatx.png';
import kapalFollowIcon from '../assets/img/boatFollow.png';
import peswatIcon from '../assets/img/plane.png';
import pesawat from '../assets/img/pesawat.png';
import radar from '../assets/img/radar.png';
import radarPic from '../assets/img/radarPic.png';
import 'leaflet-rotatedmarker'
import 'leaflet/dist/leaflet.css'
import ChatCanvas from '../pages/presentation/dashboard/ChatCanvas';

dayjs.extend(utc)

const URL_WEB_SOCKET = process.env.REACT_APP_URL_WEB_SOCKET;
let playbackTimer: ReturnType<typeof setTimeout>;

interface IMapProps {
    latitudeX: any;
    longitudeX: any;
    setLatitudeX: any;
    setLongitudeX: any;
    zoom: any;
    setZoom: any;

    handleClick2: any;
    isModal: any;
    handleClick: any;
    isModal2: boolean;
    isReportBox: boolean;
    setIsReportBox: any;
    handleReport: any;
    isGoogleMap: boolean;
    isGoogleSatelite: boolean;
    isGoogleHybrid: boolean;
    isEsriWordStreet: boolean;
    isEsriTopographic: boolean;
    isEsriOceanBasemap: boolean;
    isOpenStreetMap: boolean;
    isClouds: boolean;
    isPrecipitation: boolean;
    isSealevelpressure: boolean;
    isWindSpeed: boolean;
    isTemperature: boolean;
    isWindSpeedDirection: boolean;
    isConvectiveprecipitation: boolean;
    isPrecipitationintensity: boolean;
    isAccumulatedprecipitation: boolean;
    isAccumulatedprecipitationrain: boolean;
    isAccumulatedprecipitationsnow: boolean;
    isDepthofsnow: boolean;
    isWindspeedaltitudeofmeters: boolean;
    isAtmosphericpressuremeansealevel: boolean;
    isAirtemperatureatmeters: boolean;
    isTemperatureofdewpoint: boolean;
    isSoiltemperatureсm: boolean;
    isSoiltemperatureMoreсm: boolean;
    isRelativehumidity: boolean;
    isCloudiness: boolean;
    isSignificantWaveHeight: boolean;
    isSeaCurrent: boolean;
    isOpenSeaMap: boolean;
    isPublicTransport: boolean;
    isMeasure: boolean;
    setIsMeasure: any;
    isBoxLayer: any;

    HandleLayerGoogleMap: any;
    HandleLayerGoogleSatelite: any;
    HandleLayerGoogleHybrid: any;
    HandleLayerOpenStreetMap: any;
    HandleLayerEsriWordStreet: any;
    HandleLayerEsriTopographic: any;
    HandleLayerEsriOceanBasemap: any;

    setDataMmsi: any;
    dataPlayback: any;
    isRunPlayback: boolean;
    setIsRunPlayback: any;

    isPlayback: boolean;

    dataMmsi: any;
    setDataPlayback: any;

    handleClickPlayback: any;

    isLocalMap:boolean;
    HandleLocalMap:any;
}

const Maps: FC<IMapProps> = ({
    setLatitudeX, latitudeX,
    setLongitudeX, longitudeX,
    zoom, setZoom,

    handleClick2,
    isModal,
    handleClick,
    isModal2,
    isReportBox, setIsReportBox,
    handleReport,
    isGoogleMap,
    isGoogleSatelite,
    isGoogleHybrid,
    isEsriWordStreet,
    isEsriTopographic,
    isEsriOceanBasemap,
    isOpenStreetMap,
    isClouds,
    isPrecipitation,
    isSealevelpressure,
    isWindSpeed,
    isTemperature,
    isWindSpeedDirection,
    isConvectiveprecipitation,
    isPrecipitationintensity,
    isAccumulatedprecipitation,
    isAccumulatedprecipitationrain,
    isAccumulatedprecipitationsnow,
    isDepthofsnow,
    isWindspeedaltitudeofmeters,
    isAtmosphericpressuremeansealevel,
    isAirtemperatureatmeters,
    isTemperatureofdewpoint,
    isSoiltemperatureсm,
    isSoiltemperatureMoreсm,
    isRelativehumidity,
    isCloudiness,
    isSignificantWaveHeight,
    isSeaCurrent,
    isOpenSeaMap,
    isPublicTransport,
    isMeasure,
    setIsMeasure,

    isBoxLayer,

    HandleLayerGoogleMap,
    HandleLayerGoogleSatelite,
    HandleLayerGoogleHybrid,
    HandleLayerOpenStreetMap,
    HandleLayerEsriWordStreet,
    HandleLayerEsriTopographic,
    HandleLayerEsriOceanBasemap,

    setDataMmsi,
    dataPlayback, isRunPlayback,
    setIsRunPlayback,
    dataMmsi, setDataPlayback,
    isPlayback,
    handleClickPlayback,

    isLocalMap,HandleLocalMap
}) => {
    const [aisData, setAisData] = useState<any[]>([]);
    const [aisData2, setAisData2] = useState<any[]>([]);
    const [dataBreadcrumb, setDataBreadcrumb] = useState<any>({});
    // const Token = `Bearer ${localStorage.getItem('token')}`
    const UrlBase = process.env.REACT_APP_BASE_API_URL;
    const [myLocation, setMyLocation] = useState(false);
    const [isZoom, setIsZoom] = useState(false);
    const [mousePosX, setMousePosX] = useState<number>(0);
    const [mousePosY, setMousePosY] = useState<number>(0);
    const [adsbData, setAdsbData] = useState<any[]>([]);
    const [adsbData2, setAdsbData2] = useState<any[]>([]);
    const [isAdsb, setIsAdsb] = useState(false);
    const [isAis, setIsAis] = useState(true);
    const [aircraftId, setAircraftId] = useState<any>(0)
    const [info, setInfo] = useState<string>('')
    const [radarData, setRadarData] = useState<any[]>([]);
    const [radarData2, setRadarData2] = useState<any[]>([]);
    const [isRadar, setIsRadar] = useState(false);
    const [targetId, setTargetId] = useState<any>(0)
    const Token = `Bearer ${localStorage.getItem('token')}`
    const [latBound, setLatBound] = useState(0)
    const [lngBound, setLngBound] = useState(0)
    const [isRadarImg, setIsdRadarImg] = useState(false)

    const history = useNavigate()

    const boundRadar = getBoundsOfDistance(
        { latitude: latBound, longitude: lngBound },
        40000,
    )
    const boundRadarFix = boundRadar.map(({ latitude, longitude }) => [
        latitude,
        longitude,
    ])

    const getLoggers = async () => {
        // console.log('get logger')
        try {
            const response = await axios.get(`${UrlBase}dataloggers`, {
                headers: {
                    'Authorization': Token
                }
            });
            if (response.status === 200) {
                setLatBound(response.data[0].latitude);
                setLngBound(response.data[0].longitude)
                setLatitudeX(response.data[0].latitude);
                setLongitudeX(response.data[0].longitude)
                setMyLocation(true)
            } else {
                localStorage.removeItem('token')
                history('/auth-pages/login')
            }
        } catch (error) {
            console.log({ error });
        }

    }

    const [radarimg, setRadarImg] = useState('')

    const getRadarImg = async () => {
        // console.log('get logger')
        try {
            const response = await axios.get(`${UrlBase}radarimage`,
                // {
                //     headers: {
                //         'Authorization': Token
                //     }
                // }
            );
            if (response.status === 201) {
                setRadarImg(response.data.message)
            }
        } catch (error) {
            console.log({ error });
        }

    }

    const fetchAisData = async () => {
        try {
            const response = await axios.get(`${UrlBase}aisdataunique`);
            if (response.data.success) {
                setAisData(response.data.message);
                const mmsiData: any = [];
                response.data.message.forEach((el: any) => {
                    mmsiData.push(el.vessel.mmsi)
                });
                setDataMmsi(mmsiData.sort())
            }
        } catch (error) {
            console.log({ error });
        }
    };

    const fetchAdsbData = async () => {
        try {
            const response = await axios.get(`${UrlBase}adsbunique`);
            if (response.data.success) {
                setAdsbData(response.data.message);
            }
        } catch (error) {
            console.log({ error });
        }
    };

    const fetchRadarData = async () => {
        try {
            const response = await axios.get(`${UrlBase}radardataunique`);
            if (response.data.success) {
                setRadarData(response.data.message);
            }
        } catch (error) {
            console.log({ error });
        }
    };

    const fetchAisBreadcrumb = async (id: number) => {
        const newData: any = [];
        let dataLat = '';
        let dataLng = '';
        try {
            const response = await axios.post(`${UrlBase}breadcrumb`, { vessel_id: id });
            if (response.data.success) {
                const datax = response.data.message;
                if (datax.length > 0) {
                    datax.forEach((el: any) => {
                        dataLat = el.latitude;
                        dataLng = el.longitude;
                        newData.push([dataLat, dataLng]);
                    });
                    setDataBreadcrumb(newData);
                    // console.log('jml data', newData.length)
                }
            }
        } catch (error) {
            console.log({ error });
        }
    };
    const [loadButton, setLoadButton] = useState(false)
    const FollowCam = async (lat: number, lng: number) => {
        setLoadButton(true)
        try {
            const param = {
                "lat": lat,
                "lng": lng
            }
            const response = await axios.post(`${UrlBase}movebylatlng`, param);
            if (response.status === 200) {
                toast.success('success follow cam...')
                setLoadButton(false)
            }
        } catch (error) {
            console.log(error)
            setLoadButton(false)
        }
    }

    useEffect(() => {
        getLoggers()
        getRadarImg()
        fetchAisData();
        fetchAdsbData()
        fetchRadarData()
        const ws = new WebSocket(
            `${URL_WEB_SOCKET}`
        );

        ws.onopen = () => {
            console.log("Connection Established!");
        };
        ws.onmessage = (event) => {
            const response = JSON.parse(event.data);
            // console.log(response);

            const mmsiData = response.mmsi
            const datax: any = aisData.filter(x => parseInt(x.vessel.mmsi, 10) === mmsiData)
            // console.log(datax)
            if (datax.length > 0) {
                // console.log(datax[0].id)
                setAisData(prevState => {
                    const newState = prevState.map(obj => {
                        // 👇️ if id equals 2, update country property
                        if (obj.id === datax[0].id) {
                            return {
                                ...obj,
                                latitude: response.latitude,
                                longitude: response.longitude,
                                timestamp: response.isoDate,
                                navigation_status: response.navigationStatus,
                                course: response.courseOverGround,
                                speed: response.speedOverGround,
                                turning_rate: response.rateOfTurn,

                            };
                        }

                        // 👇️ otherwise return the object as is
                        return obj;
                    });

                    return newState;
                });
            }
            // ws.close();
        };
        ws.onclose = () => {
            console.log("Connection Closed!");
            // initWebsocket();
        };


        ws.onerror = () => {
            console.log("WS Error");
        };


        return () => {
            ws.close();
        };



        // eslint-disable-next-line react-hooks/exhaustive-deps
    }, []);


    const showData = (e: any) => {
        const key = e.id;
        const dataInfo = aisData.filter((item) => item.id === key);
        if (dataInfo.length > 0) {
            setDataBreadcrumb({})
            setBreadText('Show Breadcrumb')
            setAisData2(dataInfo);
            setInfo('Mmsi')
            handleClick();
        }
    };

    const showDataAdsb = (e: any) => {
        const key = e.id;
        const dataInfo = adsbData.filter((item) => item.id === key);
        if (dataInfo.length > 0) {
            setDataBreadcrumb({})
            setBreadText('Show Breadcrumb')
            setAdsbData2(dataInfo);
            setInfo('Adsb')
            handleClick();
        }
    };

    const showDataRadar = (e: any) => {
        const key = e.id;
        const dataInfo = radarData.filter((item) => item.id === key);
        if (dataInfo.length > 0) {
            setDataBreadcrumb({})
            setRadarData2(dataInfo);
            setInfo('Radar')
            handleClick();
        }
    };

    const [value, setValue] = React.useState('1');
    const [breadText, setBreadText] = useState('Show Breadcrumb');
    const handleChange = (event: React.SyntheticEvent, newValue: string) => {
        setValue(newValue);
    };

    const showInfo = () => {
        return (
            <>
                {aisData2.map((ais) => (
                    <>
                        <Typography variant='h6' className='title' mt={1}>
                            MMSI {ais.vessel.mmsi}
                        </Typography>

                        <Box sx={{ width: '100%', typography: 'body1' }}>
                            <TabContext value={value}>
                                <Box sx={{ borderBottom: 1, borderColor: 'divider' }}>
                                    <TabList
                                        onChange={handleChange}
                                        aria-label='lab API tabs example'>
                                        <Tab label='Info' value='1' />
                                        <Tab label='Detail' value='2' />
                                        <Tab label='Pic' value='3' />
                                    </TabList>
                                </Box>
                                <TabPanel value='1'>
                                    <table className='table-auto' style={{ color: 'black' }}>
                                        <tbody>
                                            <tr>
                                                <td className='font-bold'>Vessel Name</td>
                                                <td>:{ais.vessel.vessel_name}</td>
                                            </tr>
                                            <tr>
                                                <td className='font-bold'>Vessel Type</td>
                                                <td>:{ais.vessel.vessel_type}</td>
                                            </tr>
                                            <tr>
                                                <td className='font-bold'>Latitude</td>
                                                <td>:{ais.latitude}</td>
                                            </tr>
                                            <tr>
                                                <td className='font-bold'>Longitude</td>
                                                <td>:{ais.longitude}</td>
                                            </tr>
                                            <tr>
                                                <td className='font-bold'>Speed</td>
                                                <td>:{ais.speed}</td>
                                            </tr>
                                            <tr>
                                                <td className='font-bold'>Course</td>
                                                <td>:{ais.course}</td>
                                            </tr>
                                            <tr>
                                                <td className='font-bold'>Heading</td>
                                                <td>:{ais.heading}</td>
                                            </tr>
                                            <tr>
                                                <td className='font-bold'>Status</td>
                                                <td>:{ais.navigation_status}</td>
                                            </tr>
                                            <tr>
                                                <td className='font-bold'>Timestamp</td>
                                                <td>:{dayjs.utc(ais.timestamp, 'YYYY-MM-DD HH:mm:ss',).local().format('DD MMM YYYY, HH:mm:ss')}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <br />
                                    <Stack spacing={1}>
                                        <Button
                                            variant='contained'
                                            startIcon={
                                                breadText === 'Show Breadcrumb' ? (
                                                    <VisibilityIcon />
                                                ) : (
                                                    <VisibilityOffIcon />
                                                )
                                            }
                                            sx={{
                                                color: 'black',
                                                backgroundColor: '#CBCDBF',
                                                '&:hover': {
                                                    backgroundColor: '#D2D7BA',
                                                    color: 'black',
                                                },
                                            }}
                                            onClick={() => {
                                                // eslint-disable-next-line @typescript-eslint/no-unused-expressions
                                                breadText === 'Show Breadcrumb'
                                                    ? (setBreadText('Clear Breadcrumb'),
                                                        fetchAisBreadcrumb(ais.vessel_id))
                                                    : (setBreadText('Show Breadcrumb'),
                                                        setDataBreadcrumb({}));
                                            }}>
                                            {breadText}
                                        </Button>
                                        <Button
                                            variant='contained'
                                            startIcon={<CenterFocusWeakIcon />}
                                            sx={{
                                                color: 'black',
                                                backgroundColor: '#CBCDBF',
                                                '&:hover': {
                                                    backgroundColor: '#D2D7BA',
                                                    color: 'black',
                                                },
                                            }}
                                            onClick={() => !isRunPlayback ?
                                                handlePb(ais.vessel_id) :
                                                stopPb()}>
                                            {
                                                isRunPlayback ?
                                                    <>Stop Playback</> :
                                                    <>Playback</>
                                            }
                                        </Button>
                                    </Stack>
                                </TabPanel>
                                <TabPanel value='2' >
                                    <table className='table-auto' style={{ color: 'black' }}>
                                        <tbody>
                                            <tr>
                                                <td className='font-bold'>IMO</td>
                                                <td>:{ais.vessel.imo}</td>
                                            </tr>
                                            <tr>
                                                <td className='font-bold'>Call Sign</td>
                                                <td>:{ais.vessel.callsign}</td>
                                            </tr>
                                            <tr>
                                                <td className='font-bold'>draught</td>
                                                <td>:{ais.vessel.draught}</td>
                                            </tr>
                                            <tr>
                                                <td className='font-bold'>dimension_to_bow</td>
                                                <td>:{ais.vessel.dimension_to_bow}</td>
                                            </tr>
                                            <tr>
                                                <td className='font-bold'>dimension_to_stern</td>
                                                <td>:{ais.vessel.dimension_to_stern}</td>
                                            </tr>
                                            <tr>
                                                <td className='font-bold'>dimension_to_port</td>
                                                <td>:{ais.vessel.dimension_to_port}</td>
                                            </tr>
                                            <tr>
                                                <td className='font-bold'>dimension_to_starboard</td>
                                                <td>:{ais.vessel.dimension_to_starboard}</td>
                                            </tr>
                                            <tr>
                                                <td className='font-bold'>reported_destination</td>
                                                <td>:{ais.vessel.reported_destination}</td>
                                            </tr>
                                        </tbody>
                                    </table><br />
                                    <Stack spacing={1}>
                                        <Button
                                            variant='contained'
                                            startIcon={<CenterFocusWeakIcon />}
                                            sx={{
                                                color: 'black',
                                                backgroundColor: '#CBCDBF',
                                                '&:hover': {
                                                    backgroundColor: '#D2D7BA',
                                                    color: 'black',
                                                },
                                            }}
                                            onClick={() => !isFollow ?
                                                handleFollow(ais.id) :
                                                stopFollow()}>
                                            {
                                                isFollow ?
                                                    <>Stop Follow</> :
                                                    <>Follow</>
                                            }
                                        </Button>
                                    </Stack>

                                </TabPanel>
                                <TabPanel value='3'>
                                    <Stack spacing={1}>
                                        <img src={kapalLaut} alt='kapal laut' width='250' />
                                        {
                                            loadButton ?
                                                <LoadingButton loading variant="contained"
                                                    sx={{
                                                        color: 'black',
                                                        backgroundColor: '#CBCDBF',
                                                        '&:hover': {
                                                            backgroundColor: '#D2D7BA',
                                                            color: 'black',
                                                        },
                                                    }}
                                                >
                                                    Loading</LoadingButton> :
                                                <Button
                                                    variant='contained'
                                                    startIcon={<CenterFocusWeakIcon />}
                                                    sx={{
                                                        color: 'black',
                                                        backgroundColor: '#CBCDBF',
                                                        '&:hover': {
                                                            backgroundColor: '#D2D7BA',
                                                            color: 'black',
                                                        },
                                                    }}
                                                    onClick={
                                                        () => FollowCam(ais.latitude, ais.longitude)}>
                                                    Follow Camera
                                                </Button>

                                        }

                                    </Stack>
                                </TabPanel>
                            </TabContext>
                        </Box>
                    </>
                ))}
            </>

        )

    };

    const handlePb = async (id: any) => {
        const newData: any = [];
        const newData2: any = [];
        let lat = '';
        let lng = '';
        let lat0 = '';
        let lng0 = '';
        let head = '';
        try {
            const response = await axios.post(`${UrlBase}breadcrumb`, { vessel_id: id });
            if (response.data.success) {
                const datax = response.data.message;
                if (datax.length > 0) {
                    let i = 0
                    datax.forEach((el: any) => {
                        lat = el.latitude;
                        lng = el.longitude;
                        head = el.heading;
                        const data2 = {
                            'id': i,
                            'lat': lat,
                            'lng': lng,
                            'head': head
                        }
                        if (lat !== lat0 && lng !== lng0) {
                            newData2.push(data2)
                        }
                        newData.push([lat, lng]);
                        lat0 = lat
                        lng0 = lng
                        i++
                    });
                    setZoom(12)
                    setDataPlayback(newData2)
                    tempPlayback = newData2
                    setLinePlayback(newData);
                    setIsRunPlayback(true)
                    RunPlayback()
                }
            }
        } catch (error) {
            console.log({ error });
        }
    }

    const stopPb = () => {
        clearTimeout(playbackTimer)
        setDataPlayback([])
        setIsRunPlayback(false)
    }
    const [isFollow, setIsFollow] = useState(false)
    const [latFollow, setLatFollow] = useState(0)
    const [lngFollow, setLngFollow] = useState(0)
    const [idFollow, setIdFollow] = useState(0)

    const handleFollow = (id: any) => {
        setIsFollow(true)
        setIdFollow(id)
        const dataFollow = aisData.find(x => x.id === id)
        if (dataFollow) {
            setLatFollow(dataFollow.latitude)
            setLngFollow(dataFollow.longitude)
        }
        // console.log(id)
    }

    const CompFollow = () => {
        if (isFollow) {
            const map = useMap();
            map.setView([latFollow, lngFollow]);
        }
        return null
    }

    const stopFollow = () => {
        setIsFollow(false)
        setIdFollow(0)
    }
    const showInfoAdsb = () => {
        return (
            <>
                {adsbData2.map((item) => (
                    <>
                        <Typography variant='h6' className='title' mt={1}>
                            Aircraft Id {item.hex_ident}
                        </Typography>

                        <Box sx={{ width: '100%', typography: 'body1' }}>
                            <TabContext value={value}>
                                <Box sx={{ borderBottom: 1, borderColor: 'divider' }}>
                                    <TabList
                                        onChange={handleChange}
                                        aria-label='lab API tabs example'>
                                        <Tab label='Info' value='1' />
                                        <Tab label='Detail' value='2' />
                                        <Tab label='Pic' value='3' />
                                    </TabList>
                                </Box>
                                <TabPanel value='1'>
                                    <table className='table-auto' style={{ color: 'black' }}>
                                        <tbody>
                                            <tr>
                                                <td className='font-bold'>Altitude</td>
                                                <td>:{item.altitude}</td>
                                            </tr>
                                            <tr>
                                                <td className='font-bold'>Latitude</td>
                                                <td>:{item.latitude}</td>
                                            </tr>
                                            <tr>
                                                <td className='font-bold'>Longitude</td>
                                                <td>:{item.longitude}</td>
                                            </tr>
                                            <tr>
                                                <td className='font-bold'>Speed</td>
                                                <td>:{item.ground_speed}</td>
                                            </tr>
                                            <tr>
                                                <td className='font-bold'>Vertical Rate</td>
                                                <td>:{item.vertical_rate}</td>
                                            </tr>
                                            <tr>
                                                <td className='font-bold'>Track</td>
                                                <td>:{item.track}</td>
                                            </tr>
                                            <tr>
                                                <td className='font-bold'>Timestamp</td>
                                                <td>:{dayjs.utc(item.timestamp, 'YYYY-MM-DD HH:mm:ss',).local().format('DD MMM YYYY, HH:mm:ss')}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <br />
                                </TabPanel>
                                <TabPanel value='2'>
                                    <table className='table-auto' style={{ color: 'black' }}>
                                        <tbody>
                                            <tr>
                                                <td className='font-bold'>Manufacturer</td>
                                                <td>:{item.aircraft.manufacturer}</td>
                                            </tr>
                                            <tr>
                                                <td className='font-bold'>Model</td>
                                                <td>:{item.aircraft.model}</td>
                                            </tr>
                                            <tr>
                                                <td className='font-bold'>Registration</td>
                                                <td>:{item.aircraft.registration}</td>
                                            </tr>
                                            <tr>
                                                <td className='font-bold'>Hex_ident</td>
                                                <td>:{item.aircraft.hex_ident}</td>
                                            </tr>
                                            <tr>
                                                <td className='font-bold'>Ownop</td>
                                                <td>:{item.aircraft.ownop}</td>
                                            </tr>
                                            <tr>
                                                <td className='font-bold'>Callsign</td>
                                                <td>:{item.aircraft.callsign}</td>
                                            </tr>
                                            <tr>
                                                <td className='font-bold'>Year</td>
                                                <td>:{item.aircraft.year}</td>
                                            </tr>
                                        </tbody>
                                    </table>

                                </TabPanel>
                                <TabPanel value='3'>
                                    <img src={pesawat} alt='kapal laut' width='250' />
                                </TabPanel>
                            </TabContext>
                        </Box>
                    </>
                ))}
            </>
        )
    }

    const showInfoRadar = () => {
        return (
            <>
                {radarData2.map((item) => (
                    <>
                        <Typography variant='h6' className='title' mt={1}>
                            Target Id {item.target_id}
                        </Typography>

                        <Box sx={{ width: '100%', typography: 'body1' }}>
                            <TabContext value={value}>
                                <Box sx={{ borderBottom: 1, borderColor: 'divider' }}>
                                    <TabList
                                        onChange={handleChange}
                                        aria-label='lab API tabs example'>
                                        <Tab label='Info' value='1' />
                                        <Tab label='Detail' value='2' />
                                        <Tab label='Pic' value='3' />
                                    </TabList>
                                </Box>
                                <TabPanel value='1'>
                                    <table className='table-auto' style={{ color: 'black' }}>
                                        <tbody>
                                            <tr>
                                                <td className='font-bold'>Name</td>
                                                <td>:{item?.sensor_data?.sensor?.name}</td>
                                            </tr>
                                            <tr>
                                                <td className='font-bold'>Altitude</td>
                                                <td>:{item.altitude}</td>
                                            </tr>
                                            <tr>
                                                <td className='font-bold'>Latitude</td>
                                                <td>:{item.latitude}</td>
                                            </tr>
                                            <tr>
                                                <td className='font-bold'>Longitude</td>
                                                <td>:{item.longitude}</td>
                                            </tr>
                                            <tr>
                                                <td className='font-bold'>Speed</td>
                                                <td>:{item.ground_speed}</td>
                                            </tr>
                                            <tr>
                                                <td className='font-bold'>Range</td>
                                                <td>:{item.range}</td>
                                            </tr>
                                            <tr>
                                                <td className='font-bold'>Bearing</td>
                                                <td>:{item.bearing}</td>
                                            </tr>
                                            <tr>
                                                <td className='font-bold'>Timestamp</td>
                                                <td>:{dayjs.utc(item.timestamp, 'YYYY-MM-DD HH:mm:ss',).local().format('DD MMM YYYY, HH:mm:ss')}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <br />
                                </TabPanel>
                                <TabPanel value='2'>
                                    <table className='table-auto' style={{ color: 'black' }}>
                                        <tbody>
                                            <tr>
                                                <td className='font-bold'>Status</td>
                                                <td>:{item?.sensor_data?.sensor?.status}</td>
                                            </tr>
                                            <tr>
                                                <td className='font-bold'>Interval</td>
                                                <td>:{item?.sensor_data?.sensor?.interval}</td>
                                            </tr>
                                            <tr>
                                                <td className='font-bold'>Jarak</td>
                                                <td>:{item?.sensor_data?.sensor?.jarak}</td>
                                            </tr>
                                            <tr>
                                                <td className='font-bold'>Jumlah Data</td>
                                                <td>:{item?.sensor_data?.sensor?.jumlah_data}</td>
                                            </tr>
                                        </tbody>
                                    </table>

                                </TabPanel>
                                <TabPanel value='3'>
                                    <img src={radarPic} alt='Radar' width='250' />
                                </TabPanel>
                            </TabContext>
                        </Box>
                    </>
                ))}
            </>
        )
    }

    const iconx =
        L.icon({
            iconSize: [35, 45],
            popupAnchor: [2, -20],
            iconUrl: kapalIcon,
        });

    const iconpesawat = L.icon({
        iconSize: [55, 45],
        popupAnchor: [2, -20],
        iconUrl: peswatIcon,
    });

    const iconradar = L.icon({
        iconSize: [20, 20],
        popupAnchor: [2, -20],
        iconUrl: radar,
    });

    const iconFollow =
        L.icon({
            iconSize: [35, 45],
            popupAnchor: [2, -20],
            iconUrl: kapalFollowIcon,
        });

    const [isPopup, setIsPopup] = useState<any>('hidden')
    const [mmsi, setMmsi] = useState<string>('')
    const [vesselName, setVesselName] = useState<string>('')
    const [vesselStatus, setVesselStatus] = useState<string>('')

    const newMarker = () => {
        return (
            <MarkerClusterGroup chunkedLoading>
                {
                    aisData.map((item: any) => (
                        item.id === idFollow ?
                            <Marker
                                position={[item.latitude, item.longitude]}
                                icon={iconFollow}
                                rotationAngle={item.heading}
                                rotationOrigin="center"
                                key={item.id}
                                eventHandlers={{
                                    click: (e: any) => {
                                        showData(item);
                                    },
                                    mouseover: (e: any) => {
                                        const nama = item.vessel.vessel_name
                                        setMmsi(item.vessel.mmsi)
                                        setVesselStatus(item.navigation_status)
                                        setVesselName(nama === null ? 'No Name' : nama)
                                        setMousePosY(e.containerPoint.y - 60)
                                        setMousePosX(e.containerPoint.x - 60)
                                        setIsPopup('visible')
                                        // console.log('mouse in')
                                    },
                                    mouseout: () => {
                                        setIsPopup('hidden')
                                        setMmsi('')
                                        setVesselName('')
                                        setVesselStatus('')
                                    }
                                }}
                            />

                            :

                            <Marker
                                position={[item.latitude, item.longitude]}
                                icon={iconx}
                                rotationAngle={item.heading}
                                rotationOrigin="center"
                                key={item.id}
                                eventHandlers={{
                                    click: (e: any) => {
                                        showData(item);
                                    },
                                    mouseover: (e: any) => {
                                        const nama = item.vessel.vessel_name
                                        setMmsi(item.vessel.mmsi)
                                        setVesselStatus(item.navigation_status)
                                        setVesselName(nama === null ? 'No Name' : nama)
                                        setMousePosY(e.containerPoint.y - 60)
                                        setMousePosX(e.containerPoint.x - 60)
                                        setIsPopup('visible')
                                        // console.log('mouse in')
                                    },
                                    mouseout: () => {
                                        setIsPopup('hidden')
                                        setMmsi('')
                                        setVesselName('')
                                        setVesselStatus('')
                                    }
                                }}
                            />

                    ))
                }
                < Polyline positions={dataBreadcrumb} color='red' />
            </MarkerClusterGroup>
        );
    };

    const markerAdsb = () => {
        return (
            <MarkerClusterGroup chunkedLoading>
                {adsbData.map((item: any) => (
                    <Marker
                        position={[item.latitude, item.longitude]}
                        icon={iconpesawat}
                        rotationAngle={item.heading}
                        rotationOrigin="center"
                        key={item.id}
                        eventHandlers={{
                            click: () => {
                                showDataAdsb(item);
                            },
                            mouseover: (e: any) => {
                                setMmsi('')
                                setVesselName('')
                                setVesselStatus('')
                                // console.log(item.aircraft_id)
                                setAircraftId(item.aircraft_id)
                                setIsPopup('visible')
                                setMousePosY(e.containerPoint.y - 60)
                                setMousePosX(e.containerPoint.x - 60)
                            },
                            mouseout: () => {
                                setIsPopup('hidden')
                                setAircraftId('')
                            }
                        }}
                    />
                ))}
            </MarkerClusterGroup>
        );
    }

    const markerRadar = () => {
        return (
            <MarkerClusterGroup chunkedLoading>
                {radarData.map((item: any) => (
                    <Marker
                        position={[item.latitude, item.longitude]}
                        icon={iconradar}
                        // rotationAngle={item.heading}
                        rotationOrigin="center"
                        key={item.id}
                        eventHandlers={{
                            click: () => {
                                showDataRadar(item);
                            },
                            mouseover: (e: any) => {
                                setMmsi('')
                                setVesselName('')
                                setVesselStatus('')
                                setAircraftId('')
                                setTargetId(item.target_id)
                                setIsPopup('visible')
                                setMousePosY(e.containerPoint.y - 60)
                                setMousePosX(e.containerPoint.x - 60)
                            },
                            mouseout: () => {
                                setIsPopup('hidden')
                            }
                        }}
                    />
                ))}
            </MarkerClusterGroup>
        );
    }

    const markerPlayback = () => {
        return (
            <>{
                PlaybackData.map((item: any) => (

                    <Marker
                        position={[item.lat, item.lng]}
                        icon={iconx}
                        rotationAngle={item.head}
                        rotationOrigin="center"
                        key={item.id}
                    />

                ))
            }
                < Polyline positions={linePlayback} color='red' />
            </>
        )
    }
    const [linePlayback, setLinePlayback] = useState<any>({});
    const [PlaybackData, setPlaybackData] = useState<any[]>([]);
    const [latPlayback, setLatPlayback] = useState<any>();
    const [lngPlayback, setLngPlayback] = useState<any>();

    // const tempLine: any = []
    let i = 0
    // let rotatePrev = 0
    const RunPlayback = () => {
        if (tempPlayback.length > 0) {
            // console.log(i)
            const lat1 = parseFloat(tempPlayback[i].lat)
            const lng1 = parseFloat(tempPlayback[i].lng)
            const head = parseFloat(tempPlayback[i].head)
            let lat2 = lat1
            let lng2 = lng1
            if (i + 1 < tempPlayback.length) {
                lat2 = parseFloat(tempPlayback[i + 1].lat)
                lng2 = parseFloat(tempPlayback[i + 1].lng)
            }
            const pos1 = {
                "latitude": lat1,
                "longitude": lng1
            }
            const pos2 = {
                "latitude": lat2,
                "longitude": lng2
            }
            let rotate = 0
            if (head !== undefined) {
                rotate = head
            } else {
                rotate = Math.round(getGreatCircleBearing(pos1, pos2));
            }
            // if (rotate === 0) {
            //     rotate = rotatePrev
            // }
            // rotatePrev = rotate
            const dt = [{
                "id": i,
                "lat": lat1,
                "lng": lng1,
                "head": rotate
            }]
            setLatPlayback(lat1)
            setLngPlayback(lng1)
            setPlaybackData(dt)
            // console.log(dt)
            i++
            if (i < tempPlayback.length) {
                playbackTimer = setTimeout(RunPlayback, 200);
            } else {
                clearTimeout(playbackTimer)
                setIsRunPlayback(false)
                setTitleButton('Generate Playback')
                tempPlayback = []
            }

        }
        return null;
    }

    const ViewPlayback = () => {
        if (isRunPlayback) {
            const map = useMap();
            map.setView([latPlayback, lngPlayback], zoom);
        }
        return null
    }
    const mainMap = () => {
        return (
            <MapContainer
                center={[latitudeX, longitudeX]}
                zoom={zoom}
                zoomControl={false}
                editable='true'
                key='map'
            >
                <LayerMap
                    isGoogleMap={isGoogleMap}
                    isGoogleSatelite={isGoogleSatelite}
                    isGoogleHybrid={isGoogleHybrid}
                    isEsriWordStreet={isEsriWordStreet}
                    isEsriTopographic={isEsriTopographic}
                    isEsriOceanBasemap={isEsriOceanBasemap}
                    isOpenStreetMap={isOpenStreetMap}
                    isClouds={isClouds}
                    isPrecipitation={isPrecipitation}
                    isSealevelpressure={isSealevelpressure}
                    isWindSpeed={isWindSpeed}
                    isTemperature={isTemperature}
                    isWindSpeedDirection={isWindSpeedDirection}
                    isConvectiveprecipitation={isConvectiveprecipitation}
                    isPrecipitationintensity={isPrecipitationintensity}
                    isAccumulatedprecipitation={isAccumulatedprecipitation}
                    isAccumulatedprecipitationrain={isAccumulatedprecipitationrain}
                    isAccumulatedprecipitationsnow={isAccumulatedprecipitationsnow}
                    isDepthofsnow={isDepthofsnow}
                    isWindspeedaltitudeofmeters={isWindspeedaltitudeofmeters}
                    isAtmosphericpressuremeansealevel={isAtmosphericpressuremeansealevel}
                    isAirtemperatureatmeters={isAirtemperatureatmeters}
                    isTemperatureofdewpoint={isTemperatureofdewpoint}
                    isSoiltemperatureсm={isSoiltemperatureсm}
                    isSoiltemperatureMoreсm={isSoiltemperatureMoreсm}
                    isRelativehumidity={isRelativehumidity}
                    isCloudiness={isCloudiness}
                    isSignificantWaveHeight={isSignificantWaveHeight}
                    isSeaCurrent={isSeaCurrent}
                    isOpenSeaMap={isOpenSeaMap}
                    isPublicTransport={isPublicTransport}
                    isLocalMap={isLocalMap}
                />
                {isRunPlayback && markerPlayback()}
                {!isRunPlayback && isAis && newMarker()}
                {!isRunPlayback && isAdsb && markerAdsb()}
                {!isRunPlayback && isRadar && markerRadar()}
                <MyComponent />
                <ZoomIn />
                <MyLoc />
                <MeasureComponent />
                <ViewPlayback />
                <CompFollow />
                {
                    isRadarImg &&
                    <ImageOverlay
                        bounds={boundRadarFix}
                        opacity={1}
                        url={radarimg}
                        interactive
                    />
                }
            </MapContainer>
        );
    };
    let count = 0;
    const MeasureComponent = () => {
        if (isMeasure && count === 0) {
            const map = useMap();
            const measurePolygonControl = L.control.measurePolygon();
            measurePolygonControl.addTo(map);
            count++;
            setIsMeasure(false);
        }
        return null;
    };

    const MyComponent = () => {
        useMapEvents({
            click: () => {
                handleClick2();
            },
            mouseover: () => {
                if (isPopup) {
                    setIsPopup('hidden')
                }
            }
        });
        return null;
    };

    const MyLoc = () => {
        if (myLocation) {
            const map = useMap();
            map.flyTo([latitudeX, longitudeX], zoom);
            setMyLocation(false);
        }
        return null;
    };

    const ZoomIn = () => {
        if (isZoom) {
            const map = useMap();
            map.setZoom(zoom);
            setIsZoom(false);
        }
        return null;
    };

    const handleZoomIn = () => {
        setZoom(zoom + 1);
        setIsZoom(true);
    };

    const handleZoomOut = () => {
        setZoom(zoom - 1);
        setIsZoom(true);
    };
    const location = useGeolocation({
        enableHighAccuracy: true,
        maximumAge: 15000,
        timeout: 12000,
    });

    const Lokasi = () => {
        if (!location.error) {
            // console.log(location)
            setLatitudeX(location.latitude);
            setLongitudeX(location.longitude);
            setZoom(10);
            setMyLocation(true);
        } else {
            alert(location.error.message);
        }
    };

    function toggleFullScreen() {
        const doc = window.document;
        const docEl = doc.documentElement;

        const requestFullScreen =
            docEl.requestFullscreen ||
            docEl.requestFullscreen ||
            docEl.requestFullscreen ||
            docEl.requestFullscreen;
        const cancelFullScreen = doc.exitFullscreen || doc.exitFullscreen || doc.exitFullscreen;

        if (
            !doc.fullscreenElement &&
            !doc.fullscreenElement &&
            !doc.fullscreenElement &&
            !doc.fullscreenElement
        ) {
            requestFullScreen.call(docEl);
        } else {
            cancelFullScreen.call(doc);
        }
    }
    let tempPlayback: any = []
    const [tanggalAwal, setTanggalAwal] = useState((new Date('2023/06/02')).toISOString().split('T')[0])
    const [tanggalAkhir, setTanggalAkhir] = useState((new Date('2023/06/14')).toISOString().split('T')[0])
    const [mmsix, setMmsix] = useState('257001155')
    const [titleButton, setTitleButton] = useState('Generate Playback')

    const fecthDataPlayback = async () => {
        clearTimeout(playbackTimer)
        const newData: any = [];
        let dataLat = '';
        let dataLng = '';
        try {
            const response = await axios.post(`${UrlBase}playback`,
                {
                    "dateFrom": tanggalAwal,
                    "dateTo": tanggalAkhir,
                    "mmsi": mmsix
                });
            if (response.data.success) {
                const data = response.data.message
                if (data.length > 0) {
                    setDataPlayback(data);
                    setTitleButton('Stop Playback')
                    setIsRunPlayback(true)
                    tempPlayback = data
                    RunPlayback()
                    data.forEach((el: any) => {
                        dataLat = el.lat;
                        dataLng = el.lng;
                        newData.push([dataLat, dataLng]);
                    });
                    setLinePlayback(newData);
                    handleClickPlayback()
                } else {
                    toast.error('Empty Data')
                }
            }
        } catch (error) {
            console.log({ error });
        }

    }

    return (
        <>
            {mainMap()}
            <Drawer
                anchor='left'
                open={isModal}
                onClose={() => handleClick()}
                variant='persistent'
                PaperProps={{
                    sx: {
                        position: 'fixed',
                        top: !isMobile ? 135 : 80,
                        m: 0,
                        left: 10,
                        width: !isMobile ? 300 : 290,
                        height: 'auto',
                        borderRadius: 5,
                        backgroundColor: '#D2D7BA',
                        border: 'none',
                    },
                }}>

                {
                    info === 'Mmsi' ?
                        showInfo() :
                        info === 'Adsb' ?
                            showInfoAdsb() :
                            showInfoRadar()
                }
            </Drawer>
            {/* button kanan */}
            <Drawer
                anchor='right'
                open={isModal2}
                onClose={handleClick2}
                variant='persistent'
                PaperProps={{
                    elevation: 0,
                    sx: {
                        position: 'fixed',
                        top: 140,
                        m: 0,
                        height: 310,
                        background: 'transparent',
                        boxShadow: 'none',
                        right: 10,
                        border: 'none',
                    },
                }}>
                <Stack spacing={2} direction='column' justifyContent='right'>
                    <Tooltip title={<h6 style={{ color: 'white' }}>Zoom In</h6>} placement='left'>
                        <Fab
                            aria-label='add'
                            size='small'
                            sx={{
                                backgroundColor: '#D2D7BA',
                                color: 'black',
                                '&:hover': { backgroundColor: '#F64A00', color: 'white' },
                            }}
                            onClick={handleZoomIn}>
                            <AddOutlinedIcon fontSize='large' />
                        </Fab>
                    </Tooltip>
                    <Tooltip title={<h6 style={{ color: 'white' }}>Zoom Out</h6>} placement='left'>
                        <Fab
                            aria-label='edit'
                            size='small'
                            sx={{
                                backgroundColor: '#D2D7BA',
                                color: 'black',
                                '&:hover': { backgroundColor: '#F64A00', color: 'white' },
                            }}
                            onClick={handleZoomOut}>
                            <RemoveOutlinedIcon fontSize='large' />
                        </Fab>
                    </Tooltip>
                    <br />
                    <Tooltip
                        title={<h6 style={{ color: 'white' }}>Full Screen</h6>}
                        placement='left'>
                        <Fab
                            aria-label='edit'
                            size='small'
                            sx={{
                                backgroundColor: '#D2D7BA',
                                color: 'black',
                                '&:hover': { backgroundColor: '#F64A00', color: 'white' },
                            }}
                            // eslint-disable-next-line react/jsx-no-bind
                            onClick={toggleFullScreen}>
                            <OpenInFullOutlinedIcon fontSize='large' />
                        </Fab>
                    </Tooltip>
                    <Tooltip
                        title={<h6 style={{ color: 'white' }}>My Location</h6>}
                        placement='left'>
                        <Fab
                            aria-label='edit'
                            size='small'
                            sx={{
                                backgroundColor: '#D2D7BA',
                                color: 'black',
                                '&:hover': { backgroundColor: '#F64A00', color: 'white' },
                            }}
                            onClick={Lokasi}>
                            <PersonPinCircleOutlinedIcon fontSize='large' />
                        </Fab>
                    </Tooltip>
                </Stack>
            </Drawer>
            {/* button chat */}
            {
                !isMobile &&
                <Drawer
                    anchor='right'
                    open={isModal2}
                    onClose={handleClick2}
                    variant='persistent'
                    PaperProps={{
                        elevation: 0,
                        sx: {
                            position: 'fixed',
                            top: 450,
                            m: 0,
                            background: 'transparent',
                            boxShadow: 'none',
                            right: 10,
                            height: 50,
                            border: 'none',
                            zIndex: 2001,
                        },
                    }}>
                    <Fab
                        color='primary'
                        aria-label='edit'
                        size='small'
                        sx={{
                            color: 'white',
                            backgroundColor: '#F64A00',
                            '&:hover': { backgroundColor: '#D2D7BA', color: 'black' },
                        }}
                        onClick={handleReport}>
                        {!isReportBox ? (
                            <Tooltip title={<h6 style={{ color: 'white' }}>Chat</h6>} placement='left'>
                                <ChatOutlinedIcon fontSize='large' />
                            </Tooltip>
                        ) : (
                            <CloseOutlinedIcon fontSize='large' />
                        )}
                    </Fab>
                </Drawer>
            }

            {/* Playback */}
            <Drawer
                anchor='left'
                open={isPlayback}
                onClose={handleClickPlayback}
                variant='persistent'
                PaperProps={{
                    elevation: 0,
                    sx: {
                        position: "fixed",
                        top: !isMobile ? 135 : 80,
                        m: 0,
                        left: 10,
                        width: !isMobile ? 300 : 290,
                        height: 'auto',
                        borderRadius: 5,
                        backgroundColor: '#D2D7BA',
                        border: 'none'
                    }
                }
                }
            >
                <br />
                <Typography variant='h6' className='title'>Playback</Typography>
                <Grid padding={2}>
                    <FormControl fullWidth
                    >
                        <InputLabel id="demo-simple-select-label">MMSI</InputLabel>
                        <Select
                            labelId="demo-simple-select-label"
                            id="demo-simple-select"
                            value={mmsix}
                            label="MMSI"
                            onChange={(e) => setMmsix(e.target.value)}
                        >
                            {
                                dataMmsi.map((item: any) => (
                                    <MenuItem value={item}
                                    >{item}</MenuItem>
                                ))
                            }
                        </Select>
                    </FormControl>
                    <div className='row'>
                        <div className='col-md-6'>
                            <Stack spacing={0} mt={2}>
                                <b>Date From</b>
                                <TextField
                                    name="text1"
                                    // label="Date From"
                                    variant="outlined"
                                    InputLabelProps={{ shrink: true }}
                                    value={tanggalAwal}
                                    type='date'
                                    onChange={(e) => setTanggalAwal(e.target.value)}
                                    className='mt-3'
                                // sx={{
                                //     input: {
                                //         color: "white",
                                //         background: "black",
                                //         borderRadius: 1
                                //     },
                                // }}
                                />

                            </Stack>

                        </div>
                        <div className='col-md-6'>
                            <Stack spacing={0} mt={2}>
                                <b>Date To</b>
                                <TextField
                                    name="text1"
                                    // label="Date From"
                                    variant="outlined"
                                    InputLabelProps={{ shrink: true }}
                                    value={tanggalAkhir}
                                    type='date'
                                    onChange={(e) => setTanggalAkhir(e.target.value)}
                                    className='mt-3'
                                // sx={{
                                //     input: {
                                //         color: "white",
                                //         background: "black",
                                //         borderRadius: 1
                                //     },
                                // }}
                                />

                            </Stack>

                        </div>

                    </div>
                    <br />
                    {
                        !isRunPlayback ?
                            <Button variant="contained" fullWidth
                                sx={{ background: '#F64A00' }}
                                onClick={fecthDataPlayback}
                            >{titleButton}</Button>
                            :
                            <Button variant="contained" fullWidth
                                sx={{ background: '#F64A00' }}
                                onClick={() => {
                                    clearTimeout(playbackTimer)
                                    setDataPlayback([])
                                    setTitleButton('Generate Playback')
                                    setIsRunPlayback(false)
                                }}
                            >{titleButton}</Button>

                    }
                    <br /><br />
                </Grid>
            </Drawer>

            <ChatCanvas
                isReportBox={isReportBox}
                setIsReportBox={setIsReportBox}
            />

            <Box
                borderRadius={3}
                sx={{
                    backgroundColor: '#D2D7BA',
                    padding: 1,
                    position: 'fixed',
                    top: 80,
                    right: 60,
                    zIndex: 2000,
                    color: 'black',
                    '&:hover': { backgroundColor: '#D2D7BA', cursor: 'default' },

                    //  mt: 1
                }}
                visibility={isBoxLayer}
            // justifyContent='center'
            >
                <Stack spacing={1} direction='row'>
                    <Grid xs={6} padding={1} width={!isMobile ? 150 : 100}>

                        <Typography variant='h6' className='title1'
                            sx={{ color: 'black', borderBottom: 1 }}>
                            LIST VIEWS</Typography>
                        <Stack spacing={1}>
                            <Link href="#" underline="always" mt={1}
                                onClick={() => isAis ? setIsAis(false) : setIsAis(true)}
                                // eslint-disable-next-line no-constant-condition
                                sx={isAis
                                    ? {
                                        color: '#F64A00',
                                        "&:hover": { color: 'blue' }
                                        // , borderBottom: 1, borderColor: 'gray'
                                    }
                                    : {
                                        color: 'black',
                                        "&:hover": { color: 'blue' }
                                        // , borderBottom: 1, borderColor: 'gray'
                                    }
                                }

                            >
                                <b>AIS Data</b>
                            </Link>
                            <Link href="#" underline="always"
                                onClick={() => isAdsb ? setIsAdsb(false) : setIsAdsb(true)}
                                // eslint-disable-next-line no-constant-condition
                                sx={isAdsb
                                    ? {
                                        color: '#F64A00',
                                        "&:hover": { color: 'blue' }
                                        // , borderBottom: 1, borderColor: 'gray'
                                    }
                                    : {
                                        color: 'black',
                                        "&:hover": { color: 'blue' }
                                        // , borderBottom: 1, borderColor: 'gray'
                                    }
                                }
                            >
                                <b>ADS-B Data</b>
                            </Link>
                            {/* <b onClick={onClickADSb}>ADS-B Data</b> */}
                            <Link href="#" underline="always"
                                // eslint-disable-next-line no-constant-condition
                                onClick={() => isRadar ? setIsRadar(false) : setIsRadar(true)}
                                sx={isRadar
                                    ? {
                                        color: '#F64A00',
                                        "&:hover": { color: 'blue' }
                                        // , borderBottom: 1, borderColor: 'gray'
                                    }
                                    : {
                                        color: 'black',
                                        "&:hover": { color: 'blue' }
                                        // , borderBottom: 1, borderColor: 'gray'
                                    }
                                }
                            >
                                <b>RADAR Data</b>
                            </Link>
                            <Link href="#" underline="always"
                                // eslint-disable-next-line no-constant-condition
                                onClick={() => isRadarImg ? setIsdRadarImg(false) : setIsdRadarImg(true)}
                                sx={isRadarImg
                                    ? {
                                        color: '#F64A00',
                                        "&:hover": { color: 'blue' }
                                        // , borderBottom: 1, borderColor: 'gray'
                                    }
                                    : {
                                        color: 'black',
                                        "&:hover": { color: 'blue' }
                                        // , borderBottom: 1, borderColor: 'gray'
                                    }
                                }

                            >
                                <b>RADAR Image</b>
                            </Link>
                        </Stack>

                    </Grid>
                    <Grid xs={6} padding={1} width={150}>
                        <Typography variant='h6' className='title1'
                            sx={{ color: 'black', borderBottom: 1 }}>
                            MAP VIEWS</Typography>
                        <Stack spacing={1}>
                            <Link href="#" underline="always" mt={1}
                                onClick={HandleLocalMap}

                                sx={isLocalMap
                                    ? {
                                        color: '#F64A00',
                                        "&:hover": { color: 'blue' }
                                        // , borderBottom: 1, borderColor: 'gray'
                                    }
                                    : {
                                        color: 'black',
                                        "&:hover": { color: 'blue' }
                                        // , borderBottom: 1, borderColor: 'gray'
                                    }
                                }
                            >
                                <b>Map(Default)</b>
                            </Link>
                            <Link href="#" underline="always"
                                onClick={HandleLocalMap}

                                sx={isLocalMap
                                    ? {
                                        color: '#F64A00',
                                        "&:hover": { color: 'blue' }
                                        // , borderBottom: 1, borderColor: 'gray'
                                    }
                                    : {
                                        color: 'black',
                                        "&:hover": { color: 'blue' }
                                        // , borderBottom: 1, borderColor: 'gray'
                                    }
                                }
                            >
                                <b>Local Map</b>
                            </Link>
                            <Link href="#" underline="always"
                                onClick={HandleLayerGoogleMap}

                                sx={isGoogleMap
                                    ? {
                                        color: '#F64A00',
                                        "&:hover": { color: 'blue' }
                                        // , borderBottom: 1, borderColor: 'gray'
                                    }
                                    : {
                                        color: 'black',
                                        "&:hover": { color: 'blue' }
                                        // , borderBottom: 1, borderColor: 'gray'
                                    }
                                }
                            >
                                <b>Google Map</b>
                            </Link>
                            <Link href="#" underline="always"
                                onClick={HandleLayerGoogleSatelite}

                                sx={isGoogleSatelite
                                    ? {
                                        color: '#F64A00',
                                        "&:hover": { color: 'blue' }
                                        // , borderBottom: 1, borderColor: 'gray'
                                    }
                                    : {
                                        color: 'black',
                                        "&:hover": { color: 'blue' }
                                        // , borderBottom: 1, borderColor: 'gray'
                                    }
                                }
                            >
                                <b>Google Satelite</b>
                            </Link>
                            <Link href="#" underline="always"
                                onClick={HandleLayerGoogleHybrid}

                                sx={isGoogleHybrid
                                    ? {
                                        color: '#F64A00',
                                        "&:hover": { color: 'blue' }
                                        // , borderBottom: 1, borderColor: 'gray'
                                    }
                                    : {
                                        color: 'black',
                                        "&:hover": { color: 'blue' }
                                        // , borderBottom: 1, borderColor: 'gray'
                                    }
                                }
                            >
                                <b>Google Hybrid</b>
                            </Link>
                            <Link href="#" underline="always"
                                onClick={HandleLayerEsriWordStreet}

                                sx={isEsriWordStreet
                                    ? {
                                        color: '#F64A00',
                                        "&:hover": { color: 'blue' }
                                        // , borderBottom: 1, borderColor: 'gray'
                                    }
                                    : {
                                        color: 'black',
                                        "&:hover": { color: 'blue' }
                                        // , borderBottom: 1, borderColor: 'gray'
                                    }
                                }
                            >
                                <b>Esri World Street</b>
                            </Link>
                            <Link href="#" underline="always"
                                onClick={HandleLayerEsriTopographic}

                                sx={isEsriTopographic
                                    ? {
                                        color: '#F64A00',
                                        "&:hover": { color: 'blue' }
                                        // , borderBottom: 1, borderColor: 'gray'
                                    }
                                    : {
                                        color: 'black',
                                        "&:hover": { color: 'blue' }
                                        // , borderBottom: 1, borderColor: 'gray'
                                    }
                                }
                            >
                                <b>Esri Topographic</b>
                            </Link>
                            <Link href="#" underline="always"
                                onClick={HandleLayerEsriOceanBasemap}

                                sx={isEsriOceanBasemap
                                    ? {
                                        color: '#F64A00',
                                        "&:hover": { color: 'blue' }
                                        // , borderBottom: 1, borderColor: 'gray'
                                    }
                                    : {
                                        color: 'black',
                                        "&:hover": { color: 'blue' }
                                        // , borderBottom: 1, borderColor: 'gray'
                                    }
                                }
                            >
                                <b>Esri Ocean Basemap</b>
                            </Link>
                            <Link href="#" underline="always"
                                onClick={HandleLayerOpenStreetMap}

                                sx={isOpenStreetMap
                                    ? {
                                        color: '#F64A00',
                                        "&:hover": { color: 'blue' }
                                        // , borderBottom: 1, borderColor: 'gray'
                                    }
                                    : {
                                        color: 'black',
                                        "&:hover": { color: 'blue' }
                                        // , borderBottom: 1, borderColor: 'gray'
                                    }
                                }
                            >
                                <b>Open Street Map</b>
                            </Link>
                        </Stack>
                    </Grid>

                </Stack>
            </Box>

            <Box
                borderRadius={3}
                top={mousePosY}
                left={mousePosX}
                sx={{
                    backgroundColor: 'white',
                    padding: 1,
                    position: 'fixed',
                    zIndex: 2000,
                    color: 'black',
                    '&:hover': { backgroundColor: 'white', cursor: 'default' },

                    //  mt: 1
                }}
                visibility={!isMobile ? isPopup : 'hidden'}
                justifyContent='center'>
                <Typography className='title'>
                    <Stack direction='row'>
                        {mmsi.length > 0 ?
                            <>
                                MMSI: <div style={{ color: '#F64A00' }}><b>{mmsi}</b> </div>
                            </>
                            : aircraftId > 0 ?
                                <>
                                    aircraft_id : <div style={{ color: '#F64A00' }}><b>{aircraftId}</b> </div>
                                </>
                                :
                                <>
                                    target_id : <div style={{ color: '#F64A00' }}><b>{targetId}</b> </div>
                                </>
                        }
                    </Stack>
                </Typography>
            </Box>

            <Box
                borderRadius={3}
                top={17}
                right={470}
                sx={{
                    backgroundColor: 'black',
                    padding: 1,
                    position: 'fixed',
                    zIndex: 2000,
                    color: 'white',
                    '&:hover': { backgroundColor: 'white', cursor: 'default' },

                    //  mt: 1
                }}
                visibility={!isMobile ? isPopup : 'hidden'}
                justifyContent='center'>
                <Typography className='title'>
                    <Stack direction='row'>
                        {
                            vesselName.length > 0 ?
                                <>
                                    Vessel Name : <div style={{ color: '#F64A00' }}><b>{vesselName}</b> </div>
                                    , Status : <div style={{ color: '#F64A00' }}><b>{vesselStatus}</b> </div>
                                </>
                                : null
                        }
                    </Stack>
                </Typography>
            </Box>
        </>
    );
};

export default Maps;


