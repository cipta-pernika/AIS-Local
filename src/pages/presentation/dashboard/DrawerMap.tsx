import { Box, Drawer, Fab, Grid, Link, Stack, Typography } from '@mui/material';
import React, { FC, useContext } from 'react'
// eslint-disable-next-line import/no-extraneous-dependencies
import { isMobile } from 'react-device-detect';
import MapOutlinedIcon from '@mui/icons-material/MapOutlined';
import CloseOutlinedIcon from '@mui/icons-material/CloseOutlined';
import DatasetOutlinedIcon from '@mui/icons-material/DatasetOutlined';
import RadarOutlinedIcon from '@mui/icons-material/RadarOutlined';
import GroupOutlinedIcon from '@mui/icons-material/GroupOutlined';
import LogoutOutlinedIcon from '@mui/icons-material/LogoutOutlined';
import FormatListBulletedOutlinedIcon from '@mui/icons-material/FormatListBulletedOutlined';
// eslint-disable-next-line import/no-extraneous-dependencies
import { useNavigate } from 'react-router';
import AccordionMap from './AccordionMap';
import BottomMenu from './BottomMenu';
import SettingPage from '../setting/SettingPage';
import WeatherButton from './WeatherButton';
import { demoPagesMenu } from '../../../menu';
import AuthContext from '../../../contexts/authContext';

interface IDrawerProps {
    isModal3: boolean;
    handleClick: any;
    isModal2: boolean;
    handleClickSetting: any;
    handleClickWeather: any;
    handleClickFilter: any;
    handleClickPlayback: any;
    handleClickCam: any;
    handleClick2: any;
    isModal4: boolean;
    handleClick3: any;
    isSetting: boolean;
    isWeather: boolean;

    isClouds: boolean;
    setIsClouds: any;
    isPrecipitation: boolean;
    setIsPrecipitation: any;
    isSealevelpressure: boolean;
    setIsSealevelpressure: any;
    isWindSpeed: boolean;
    setIsWindSpeed: any;
    isTemperature: boolean;
    setIsTemperature: any;
    isWindSpeedDirection: boolean;
    setIsWindSpeedDirection: any;
    isConvectiveprecipitation: boolean;
    setIsConvectiveprecipitation: any;
    isPrecipitationintensity: boolean;
    setIsPrecipitationintensity: any;
    isAccumulatedprecipitation: boolean;
    setIsAccumulatedprecipitation: any;
    isAccumulatedprecipitationrain: boolean;
    setIsAccumulatedprecipitationrain: any;
    isAccumulatedprecipitationsnow: boolean;
    setIsAccumulatedprecipitationsnow: any;
    isDepthofsnow: boolean;
    setIsDepthofsnow: any;
    isWindspeedaltitudeofmeters: boolean;
    setIsWindspeedaltitudeofmeters: any;
    isAtmosphericpressuremeansealevel: boolean;
    setIsAtmosphericpressuremeansealevel: any;
    isAirtemperatureatmeters: boolean;
    setIsAirtemperatureatmeters: any;
    isTemperatureofdewpoint: boolean;
    setIsTemperatureofdewpoint: any;
    isSoiltemperatureсm: boolean;
    setIsSoiltemperatureсm: any;
    isSoiltemperatureMoreсm: boolean;
    setIsSoiltemperatureMoreсm: any;
    isRelativehumidity: boolean;
    setIsRelativehumidity: any;
    isCloudiness: boolean;
    setIsCloudiness: any;
    isSignificantWaveHeight: boolean;
    setIsSignificantWaveHeight: any;
    isSeaCurrent: boolean;
    setIsSeaCurrent: any;
    isOpenSeaMap: boolean;
    setIsOpenSeaMap: any;
    isPublicTransport: boolean;
    setIsPublicTransport: any;

    setIsBoxLayer: any;
    isBoxLayer: any;

    isOpenLoggers: boolean;
    setIsOpenLoggers: any;
    setIsModal4: any;
    isOpenSensors: boolean;
    setIsOpenSensors: any;
    isOpenUsers: boolean;
    setIsOpenUsers: any;

    isAisList: boolean;
    setIsAisList: any;
    isAdsbList: boolean;
    setIsAdsbList: any;
    isRadarList: boolean;
    setIsRadarList: any;


}

const DrawerMap: FC<IDrawerProps> = ({
    isModal3, handleClick,
    isModal2, handleClickSetting,
    handleClickWeather, handleClickFilter,
    handleClickPlayback, handleClick2, handleClickCam,
    isModal4, handleClick3,
    isSetting, isWeather,

    isClouds, setIsClouds,
    isPrecipitation, setIsPrecipitation,
    isSealevelpressure, setIsSealevelpressure,
    isWindSpeed, setIsWindSpeed,
    isTemperature, setIsTemperature,
    isWindSpeedDirection, setIsWindSpeedDirection,
    isConvectiveprecipitation, setIsConvectiveprecipitation,
    isPrecipitationintensity, setIsPrecipitationintensity,
    isAccumulatedprecipitation, setIsAccumulatedprecipitation,
    isAccumulatedprecipitationrain, setIsAccumulatedprecipitationrain,
    isAccumulatedprecipitationsnow, setIsAccumulatedprecipitationsnow,
    isDepthofsnow, setIsDepthofsnow,
    isWindspeedaltitudeofmeters, setIsWindspeedaltitudeofmeters,
    isAtmosphericpressuremeansealevel, setIsAtmosphericpressuremeansealevel,
    isAirtemperatureatmeters, setIsAirtemperatureatmeters,
    isTemperatureofdewpoint, setIsTemperatureofdewpoint,
    isSoiltemperatureсm, setIsSoiltemperatureсm,
    isSoiltemperatureMoreсm, setIsSoiltemperatureMoreсm,
    isRelativehumidity, setIsRelativehumidity,
    isCloudiness, setIsCloudiness,
    isSignificantWaveHeight, setIsSignificantWaveHeight,
    isSeaCurrent, setIsSeaCurrent,
    isOpenSeaMap, setIsOpenSeaMap,
    isPublicTransport, setIsPublicTransport,

    setIsBoxLayer, isBoxLayer,

    isOpenLoggers, setIsOpenLoggers, setIsModal4,
    isOpenSensors, setIsOpenSensors,
    isOpenUsers, setIsOpenUsers,

    isAisList, setIsAisList,
    isAdsbList, setIsAdsbList,
    isRadarList, setIsRadarList,


}) => {
    const { userData, setUser } = useContext(AuthContext);
    const navigate = useNavigate();
    return (
        <div>
            {/* Info Kiri */}
            {
                !isMobile &&
                <Drawer
                    anchor='left'
                    open={isModal3}
                    onClose={handleClick}
                    variant='persistent'
                    PaperProps={{
                        sx: {
                            position: "fixed",
                            top: 140,
                            left: 10,
                            m: 0,
                            height: 'auto',
                            // borderRadius: 3,
                            background: 'transparent',
                            border: 'none'
                        }
                    }}
                    sx={{ zIndex: 0 }}
                >
                    <AccordionMap />
                </Drawer>

            }
            {/* Menu Bawah */}
            <Drawer
                anchor='bottom'
                open={isModal2}
                onClose={handleClick}
                variant='persistent'
                PaperProps={{
                    sx: {
                        // position: "fixed",
                        bottom: !isMobile ? 25 : 0,
                        m: 0,
                        color: 'white',
                        // backgroundColor: '#363940',
                        backgroundColor: '#D2D7BA ',
                        borderRadius: 3,
                        width: !isMobile ? '33%' : '100%',
                        height: 85,
                        justifyContent: 'center',
                        // justifyItems: 'center'
                        // opacity: 0.5,
                        boxShadow: 'none',
                        justifySelf: 'center',
                        background: 'transparent',
                        left: !isMobile ? '33%' : 0,
                        border: 'none'
                    }
                }}

            >
                <BottomMenu
                    handleClickSetting={handleClickSetting}
                    handleClickWeather={handleClickWeather}
                    handleClickFilter={handleClickFilter}
                    handleClickCam={handleClickCam}
                    handleClickPlayback={handleClickPlayback}
                />
            </Drawer>
            {/* Layer dan View */}
            <Drawer
                anchor='right'
                open={isModal2}
                onClose={handleClick2}
                variant='persistent'
                PaperProps={{
                    elevation: 0,
                    sx: {
                        position: "fixed",
                        top: 80,
                        m: 0,
                        height: 'auto',
                        right: 10,
                        background: 'transparent',
                        border: 'none'
                    }
                }
                }
            >
                <Fab
                    aria-label='add'
                    size='small'
                    sx={isBoxLayer === 'hidden' ?
                        {
                            backgroundColor: '#D2D7BA',
                            color: 'black',
                            '&:hover': { backgroundColor: '#F64A00', color: 'white' },
                        } :
                        {
                            backgroundColor: '#F64A00',
                            color: 'white',
                            '&:hover': { backgroundColor: '#D2D7BA', color: 'black' },
                        }
                    }
                    onClick={() =>
                        isBoxLayer === 'hidden' ? (setIsBoxLayer('visible'), isModal4 ? setIsModal4(false) : null) : setIsBoxLayer('hidden')
                    }
                >
                    {isBoxLayer === 'hidden' ? (
                        <MapOutlinedIcon fontSize='large' />
                    ) : (
                        <CloseOutlinedIcon fontSize='large' />
                    )}
                </Fab>
            </Drawer>
            {/* Menu Kanan */}
            <Drawer
                anchor='right'
                open={isModal4}
                onClose={handleClick3}
                variant='persistent'
                PaperProps={{
                    elevation: 0,
                    sx: {
                        position: "fixed",
                        top: 80,
                        m: 0,
                        // eslint-disable-next-line no-constant-condition
                        right: isModal2 ? 60 : 10,
                        width: 200,
                        height: 'auto',
                        borderRadius: 5,
                        backgroundColor: '#D2D7BA',
                        border: 'none'
                        , zIndex: 2001
                    }
                }
                }
            >
                {
                    !isMobile &&
                    <>
                        <Typography variant='h6' className='title' mt={1}>MASTER</Typography><Grid xs={12} padding={2}>
                            <Stack spacing={2}>
                                <Link href="#" underline="always"
                                    sx={{
                                        color: 'black',
                                        "&:hover": { color: '#F64A00' }
                                    }}
                                    onClick={() => isOpenLoggers ?
                                        setIsOpenLoggers(false) :
                                        (setIsOpenLoggers(true), setIsModal4(false))}
                                >
                                    <DatasetOutlinedIcon fontSize='medium' /> <b>Data Loggers</b>
                                </Link>
                                <Link href="#" underline="always"
                                    sx={{
                                        color: 'black',
                                        "&:hover": { color: '#F64A00' }
                                    }}
                                    onClick={() => isOpenSensors ?
                                        setIsOpenSensors(false) :
                                        (setIsOpenSensors(true), setIsModal4(false))}
                                >
                                    <RadarOutlinedIcon fontSize='medium' /> <b>Sensors</b>
                                </Link>
                            </Stack>
                        </Grid><Typography variant='h6' className='title' mt={1}>LIST</Typography><Grid xs={12} padding={2}>
                            <Stack spacing={2}>
                                <Link href="#" underline="always"
                                    sx={{
                                        color: 'black',
                                        "&:hover": { color: '#F64A00' }
                                    }}
                                    onClick={() => isAisList ?
                                        setIsAisList(false) :
                                        (setIsAisList(true), setIsModal4(false))}
                                >
                                    <FormatListBulletedOutlinedIcon fontSize='medium' /> <b>AIS</b>
                                </Link>
                                <Link href="#" underline="always"
                                    sx={{
                                        color: 'black',
                                        "&:hover": { color: '#F64A00' }
                                    }}
                                    onClick={() => isAdsbList ?
                                        setIsAdsbList(false) :
                                        (setIsAdsbList(true), setIsModal4(false))}
                                >
                                    <FormatListBulletedOutlinedIcon fontSize='medium' /> <b>ADS-B</b>
                                </Link>
                                <Link href="#" underline="always"
                                    sx={{
                                        color: 'black',
                                        "&:hover": { color: '#F64A00' }
                                    }}
                                    onClick={() => isRadarList ?
                                        setIsRadarList(false) :
                                        (setIsRadarList(true), setIsModal4(false))}
                                >
                                    <FormatListBulletedOutlinedIcon fontSize='medium' /> <b>Radar</b>
                                </Link>
                            </Stack>
                        </Grid></>
                }
                <Typography variant='h6' className='title' mt={1}>USER </Typography>
                <Grid xs={12} padding={2}>
                    <Stack spacing={2}>
                        {
                            !isMobile &&
                            <Link href="#" underline="always"
                                sx={{
                                    color: 'black',
                                    "&:hover": { color: '#F64A00' }
                                }}
                                onClick={() => isOpenUsers ?
                                    setIsOpenUsers(false) :
                                    (setIsOpenUsers(true), setIsModal4(false))}
                            >
                                <GroupOutlinedIcon fontSize='medium' /> <b>Users</b>
                            </Link>

                        }
                        <Link href="#" underline="always"
                            onClick={() => {
                                console.log(userData)
                                if (setUser) {
                                    setUser('');
                                }
                                localStorage.setItem('token', '');
                                navigate(`../${demoPagesMenu.login.path}`);
                                // eslint-disable-next-line no-restricted-globals
                                location.reload()
                            }}
                            sx={{
                                color: 'black',
                                "&:hover": { color: '#F64A00' }
                            }}
                        >
                            <LogoutOutlinedIcon fontSize='medium' /> <b>Logout</b>
                        </Link>
                    </Stack>
                </Grid>
            </Drawer>
            {/* Setting */}
            <Drawer
                anchor='left'
                open={isSetting}
                onClose={handleClickSetting}
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
                        border: 'none',
                        maxHeight: 300,
                        // justifyContent: 'center'
                        // textAlign: 'center'
                    }
                }
                }

            >
                <br />
                <Typography variant='h6' className='title'>Setting</Typography>
                <Box padding={1}>
                    <SettingPage
                        handleClickSetting={handleClickSetting}
                    />
                </Box>
            </Drawer>
            {/* Weather */}
            <Drawer
                anchor='left'
                open={isWeather}
                onClose={handleClickWeather}
                variant='persistent'
                PaperProps={{
                    elevation: 0,
                    sx: {
                        position: "fixed",
                        top: !isMobile ? 135 : 80,
                        m: 0,
                        left: 10,
                        width: !isMobile ? 400 : 290,
                        height: !isMobile ? '73%' : '65%',
                        borderRadius: 5,
                        // backgroundColor: '#D2D7BA',
                        backgroundColor: 'white',
                        border: 'none',
                        padding: 2
                    }
                }
                }
            >

                <Typography variant='h6' className='title' >Weather</Typography>

                <WeatherButton
                    isClouds={isClouds}
                    setIsClouds={setIsClouds}
                    isPrecipitation={isPrecipitation}
                    setIsPrecipitation={setIsPrecipitation}
                    isSealevelpressure={isSealevelpressure}
                    setIsSealevelpressure={setIsSealevelpressure}
                    isWindSpeed={isWindSpeed}
                    setIsWindSpeed={setIsWindSpeed}
                    isTemperature={isTemperature}
                    setIsTemperature={setIsTemperature}
                    isWindSpeedDirection={isWindSpeedDirection}
                    setIsWindSpeedDirection={setIsWindSpeedDirection}
                    isConvectiveprecipitation={isConvectiveprecipitation}
                    setIsConvectiveprecipitation={setIsConvectiveprecipitation}
                    isPrecipitationintensity={isPrecipitationintensity}
                    setIsPrecipitationintensity={setIsPrecipitationintensity}
                    isAccumulatedprecipitation={isAccumulatedprecipitation}
                    setIsAccumulatedprecipitation={setIsAccumulatedprecipitation}
                    isAccumulatedprecipitationrain={isAccumulatedprecipitationrain}
                    setIsAccumulatedprecipitationrain={setIsAccumulatedprecipitationrain}
                    isAccumulatedprecipitationsnow={isAccumulatedprecipitationsnow}
                    setIsAccumulatedprecipitationsnow={setIsAccumulatedprecipitationsnow}
                    isDepthofsnow={isDepthofsnow}
                    setIsDepthofsnow={setIsDepthofsnow}
                    isWindspeedaltitudeofmeters={isWindspeedaltitudeofmeters}
                    setIsWindspeedaltitudeofmeters={setIsWindspeedaltitudeofmeters}
                    isAtmosphericpressuremeansealevel={isAtmosphericpressuremeansealevel}
                    setIsAtmosphericpressuremeansealevel={setIsAtmosphericpressuremeansealevel}
                    isAirtemperatureatmeters={isAirtemperatureatmeters}
                    setIsAirtemperatureatmeters={setIsAirtemperatureatmeters}
                    isTemperatureofdewpoint={isTemperatureofdewpoint}
                    setIsTemperatureofdewpoint={setIsTemperatureofdewpoint}
                    isSoiltemperatureсm={isSoiltemperatureсm}
                    setIsSoiltemperatureсm={setIsSoiltemperatureсm}
                    isSoiltemperatureMoreсm={isSoiltemperatureMoreсm}
                    setIsSoiltemperatureMoreсm={setIsSoiltemperatureMoreсm}
                    isRelativehumidity={isRelativehumidity}
                    setIsRelativehumidity={setIsRelativehumidity}
                    isCloudiness={isCloudiness}
                    setIsCloudiness={setIsCloudiness}
                    isSignificantWaveHeight={isSignificantWaveHeight}
                    setIsSignificantWaveHeight={setIsSignificantWaveHeight}
                    isSeaCurrent={isSeaCurrent}
                    setIsSeaCurrent={setIsSeaCurrent}
                    isOpenSeaMap={isOpenSeaMap}
                    setIsOpenSeaMap={setIsOpenSeaMap}
                    isPublicTransport={isPublicTransport}
                    setIsPublicTransport={setIsPublicTransport}
                />

            </Drawer>


        </div >
    )
}

export default DrawerMap