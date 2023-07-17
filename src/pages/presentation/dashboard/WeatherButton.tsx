import { Button, Grid, Stack } from '@mui/material'
import React, { FC } from 'react'

interface IWeatherProps {
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
}

const WeatherButton: FC<IWeatherProps> = ({
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
    isPublicTransport, setIsPublicTransport
}) => {
    return (
        <div>
            <Stack direction='row' spacing={2}>
                <Grid xs={6} width='50%'>
                    <Stack spacing={1} mt={1}>
                        <Button onClick={() => isClouds ? setIsClouds(false) : setIsClouds(true)}

                            sx={isClouds
                                ? {
                                    backgroundColor: '#F64A00', color: 'white', padding: 1,
                                    "&:hover": { backgroundColor: '#F64A00', color: 'lime' }
                                }
                                : {
                                    backgroundColor: '#CBCDBF', color: 'black', padding: 1,
                                    "&:hover": { backgroundColor: '#D2D7BA', color: 'black' }
                                }
                            }

                        >Clouds</Button>

                        <Button onClick={() => isPrecipitation ? setIsPrecipitation(false) : setIsPrecipitation(true)}

                            sx={isPrecipitation
                                ? {
                                    backgroundColor: '#F64A00', color: 'white', padding: 1,
                                    "&:hover": { backgroundColor: '#F64A00', color: 'lime' }
                                }
                                : {
                                    backgroundColor: '#CBCDBF', color: 'black', padding: 1,
                                    "&:hover": { backgroundColor: '#D2D7BA', color: 'black' }
                                }
                            }

                        >Precipitation</Button>
                        <Button onClick={() => isSealevelpressure ? setIsSealevelpressure(false) : setIsSealevelpressure(true)}

                            sx={isSealevelpressure
                                ? {
                                    backgroundColor: '#F64A00', color: 'white', padding: 1,
                                    "&:hover": { backgroundColor: '#F64A00', color: 'lime' }
                                }
                                : {
                                    backgroundColor: '#CBCDBF', color: 'black', padding: 1,
                                    "&:hover": { backgroundColor: '#D2D7BA', color: 'black' }
                                }
                            }

                        >Sea level pressure</Button>
                        <Button onClick={() => isWindSpeed ? setIsWindSpeed(false) : setIsWindSpeed(true)}

                            sx={isWindSpeed
                                ? {
                                    backgroundColor: '#F64A00', color: 'white', padding: 1,
                                    "&:hover": { backgroundColor: '#F64A00', color: 'lime' }
                                }
                                : {
                                    backgroundColor: '#CBCDBF', color: 'black', padding: 1,
                                    "&:hover": { backgroundColor: '#D2D7BA', color: 'black' }
                                }
                            }

                        >Wind Speed</Button>
                        <Button onClick={() => isTemperature ? setIsTemperature(false) : setIsTemperature(true)}

                            sx={isTemperature
                                ? {
                                    backgroundColor: '#F64A00', color: 'white', padding: 1,
                                    "&:hover": { backgroundColor: '#F64A00', color: 'lime' }
                                }
                                : {
                                    backgroundColor: '#CBCDBF', color: 'black', padding: 1,
                                    "&:hover": { backgroundColor: '#D2D7BA', color: 'black' }
                                }
                            }

                        >Temperature</Button>
                        <Button onClick={() => isWindSpeedDirection ? setIsWindSpeedDirection(false) : setIsWindSpeedDirection(true)}

                            sx={isWindSpeedDirection
                                ? {
                                    backgroundColor: '#F64A00', color: 'white', padding: 1,
                                    "&:hover": { backgroundColor: '#F64A00', color: 'lime' }
                                }
                                : {
                                    backgroundColor: '#CBCDBF', color: 'black', padding: 1,
                                    "&:hover": { backgroundColor: '#D2D7BA', color: 'black' }
                                }
                            }

                        >Wind Speed & Direction</Button>
                        <Button onClick={() => isConvectiveprecipitation ? setIsConvectiveprecipitation(false) : setIsConvectiveprecipitation(true)}

                            sx={isConvectiveprecipitation
                                ? {
                                    backgroundColor: '#F64A00', color: 'white', padding: 1,
                                    "&:hover": { backgroundColor: '#F64A00', color: 'lime' }
                                }
                                : {
                                    backgroundColor: '#CBCDBF', color: 'black', padding: 1,
                                    "&:hover": { backgroundColor: '#D2D7BA', color: 'black' }
                                }
                            }

                        >Convective precipitation</Button>
                        <Button onClick={() => isPrecipitationintensity ? setIsPrecipitationintensity(false) : setIsPrecipitationintensity(true)}

                            sx={isPrecipitationintensity
                                ? {
                                    backgroundColor: '#F64A00', color: 'white', padding: 1,
                                    "&:hover": { backgroundColor: '#F64A00', color: 'lime' }
                                }
                                : {
                                    backgroundColor: '#CBCDBF', color: 'black', padding: 1,
                                    "&:hover": { backgroundColor: '#D2D7BA', color: 'black' }
                                }
                            }

                        >Precipitation intensity</Button>
                        <Button onClick={() => isAccumulatedprecipitation ? setIsAccumulatedprecipitation(false) : setIsAccumulatedprecipitation(true)}

                            sx={isAccumulatedprecipitation
                                ? {
                                    backgroundColor: '#F64A00', color: 'white', padding: 1,
                                    "&:hover": { backgroundColor: '#F64A00', color: 'lime' }
                                }
                                : {
                                    backgroundColor: '#CBCDBF', color: 'black', padding: 1,
                                    "&:hover": { backgroundColor: '#D2D7BA', color: 'black' }
                                }
                            }

                        >Accumulated precipitation</Button>
                        <Button onClick={() => isAccumulatedprecipitationrain ? setIsAccumulatedprecipitationrain(false) : setIsAccumulatedprecipitationrain(true)}

                            sx={isAccumulatedprecipitationrain
                                ? {
                                    backgroundColor: '#F64A00', color: 'white', padding: 1,
                                    "&:hover": { backgroundColor: '#F64A00', color: 'lime' }
                                }
                                : {
                                    backgroundColor: '#CBCDBF', color: 'black', padding: 1,
                                    "&:hover": { backgroundColor: '#D2D7BA', color: 'black' }
                                }
                            }

                        >Accumulated precipitation - rain</Button>
                        <Button onClick={() => isAccumulatedprecipitationsnow ? setIsAccumulatedprecipitationsnow(false) : setIsAccumulatedprecipitationsnow(true)}

                            sx={isAccumulatedprecipitationsnow
                                ? {
                                    backgroundColor: '#F64A00', color: 'white', padding: 1,
                                    "&:hover": { backgroundColor: '#F64A00', color: 'lime' }
                                }
                                : {
                                    backgroundColor: '#CBCDBF', color: 'black', padding: 1,
                                    "&:hover": { backgroundColor: '#D2D7BA', color: 'black' }
                                }
                            }

                        >Accumulated precipitation - snow</Button>
                        <Button onClick={() => isDepthofsnow ? setIsDepthofsnow(false) : setIsDepthofsnow(true)}

                            sx={isDepthofsnow
                                ? {
                                    backgroundColor: '#F64A00', color: 'white', padding: 1,
                                    "&:hover": { backgroundColor: '#F64A00', color: 'lime' }
                                }
                                : {
                                    backgroundColor: '#CBCDBF', color: 'black', padding: 1,
                                    "&:hover": { backgroundColor: '#D2D7BA', color: 'black' }
                                }
                            }

                        >Depth of snow</Button>
                        <Button onClick={() => isWindspeedaltitudeofmeters ? setIsWindspeedaltitudeofmeters(false) : setIsWindspeedaltitudeofmeters(true)}

                            sx={isWindspeedaltitudeofmeters
                                ? {
                                    backgroundColor: '#F64A00', color: 'white', padding: 1,
                                    "&:hover": { backgroundColor: '#F64A00', color: 'lime' }
                                }
                                : {
                                    backgroundColor: '#CBCDBF', color: 'black', padding: 1,
                                    "&:hover": { backgroundColor: '#D2D7BA', color: 'black' }
                                }
                            }

                        >Wind speed altitude of 10 meters</Button>
                    </Stack>

                </Grid>
                <Grid xs={6} width='50%'>
                    <Stack spacing={1} mt={1}>

                        <Button onClick={() => isAtmosphericpressuremeansealevel ? setIsAtmosphericpressuremeansealevel(false) : setIsAtmosphericpressuremeansealevel(true)}

                            sx={isAtmosphericpressuremeansealevel
                                ? {
                                    backgroundColor: '#F64A00', color: 'white', padding: 1,
                                    "&:hover": { backgroundColor: '#F64A00', color: 'lime' }
                                }
                                : {
                                    backgroundColor: '#CBCDBF', color: 'black', padding: 1,
                                    "&:hover": { backgroundColor: '#D2D7BA', color: 'black' }
                                }
                            }

                        >Atmospheric pressure mean sea level</Button>
                        <Button onClick={() => isAirtemperatureatmeters ? setIsAirtemperatureatmeters(false) : setIsAirtemperatureatmeters(true)}

                            sx={isAirtemperatureatmeters
                                ? {
                                    backgroundColor: '#F64A00', color: 'white', padding: 1,
                                    "&:hover": { backgroundColor: '#F64A00', color: 'lime' }
                                }
                                : {
                                    backgroundColor: '#CBCDBF', color: 'black', padding: 1,
                                    "&:hover": { backgroundColor: '#D2D7BA', color: 'black' }
                                }
                            }

                        >Air temperature at 2 meters</Button>
                        <Button onClick={() => isTemperatureofdewpoint ? setIsTemperatureofdewpoint(false) : setIsTemperatureofdewpoint(true)}

                            sx={isTemperatureofdewpoint
                                ? {
                                    backgroundColor: '#F64A00', color: 'white', padding: 1,
                                    "&:hover": { backgroundColor: '#F64A00', color: 'lime' }
                                }
                                : {
                                    backgroundColor: '#CBCDBF', color: 'black', padding: 1,
                                    "&:hover": { backgroundColor: '#D2D7BA', color: 'black' }
                                }
                            }

                        >Temperature of dew point</Button>
                        <Button onClick={() => isSoiltemperatureсm ? setIsSoiltemperatureсm(false) : setIsSoiltemperatureсm(true)}

                            sx={isSoiltemperatureсm
                                ? {
                                    backgroundColor: '#F64A00', color: 'white', padding: 1,
                                    "&:hover": { backgroundColor: '#F64A00', color: 'lime' }
                                }
                                : {
                                    backgroundColor: '#CBCDBF', color: 'black', padding: 1,
                                    "&:hover": { backgroundColor: '#D2D7BA', color: 'black' }
                                }
                            }

                        >Soil temperature 0-10 сm</Button>
                        <Button onClick={() => isSoiltemperatureMoreсm ? setIsSoiltemperatureMoreсm(false) : setIsSoiltemperatureMoreсm(true)}

                            sx={isSoiltemperatureMoreсm
                                ? {
                                    backgroundColor: '#F64A00', color: 'white', padding: 1,
                                    "&:hover": { backgroundColor: '#F64A00', color: 'lime' }
                                }
                                : {
                                    backgroundColor: '#CBCDBF', color: 'black', padding: 1,
                                    "&:hover": { backgroundColor: '#D2D7BA', color: 'black' }
                                }
                            }

                        >Soil temperature {'>'} 10 сm</Button>
                        <Button onClick={() => isRelativehumidity ? setIsRelativehumidity(false) : setIsRelativehumidity(true)}

                            sx={isRelativehumidity
                                ? {
                                    backgroundColor: '#F64A00', color: 'white', padding: 1,
                                    "&:hover": { backgroundColor: '#F64A00', color: 'lime' }
                                }
                                : {
                                    backgroundColor: '#CBCDBF', color: 'black', padding: 1,
                                    "&:hover": { backgroundColor: '#D2D7BA', color: 'black' }
                                }
                            }

                        >Relative humidity</Button>
                        <Button onClick={() => isCloudiness ? setIsCloudiness(false) : setIsCloudiness(true)}

                            sx={isCloudiness
                                ? {
                                    backgroundColor: '#F64A00', color: 'white', padding: 1,
                                    "&:hover": { backgroundColor: '#F64A00', color: 'lime' }
                                }
                                : {
                                    backgroundColor: '#CBCDBF', color: 'black', padding: 1,
                                    "&:hover": { backgroundColor: '#D2D7BA', color: 'black' }
                                }
                            }

                        >Cloudiness</Button>
                        <Button onClick={() => isSignificantWaveHeight ? setIsSignificantWaveHeight(false) : setIsSignificantWaveHeight(true)}

                            sx={isSignificantWaveHeight
                                ? {
                                    backgroundColor: '#F64A00', color: 'white', padding: 1,
                                    "&:hover": { backgroundColor: '#F64A00', color: 'lime' }
                                }
                                : {
                                    backgroundColor: '#CBCDBF', color: 'black', padding: 1,
                                    "&:hover": { backgroundColor: '#D2D7BA', color: 'black' }
                                }
                            }

                        >Significant Wave Height</Button>
                        <Button onClick={() => isSeaCurrent ? setIsSeaCurrent(false) : setIsSeaCurrent(true)}

                            sx={isSeaCurrent
                                ? {
                                    backgroundColor: '#F64A00', color: 'white', padding: 1,
                                    "&:hover": { backgroundColor: '#F64A00', color: 'lime' }
                                }
                                : {
                                    backgroundColor: '#CBCDBF', color: 'black', padding: 1,
                                    "&:hover": { backgroundColor: '#D2D7BA', color: 'black' }
                                }
                            }

                        >Sea Current</Button>
                        <Button onClick={() => isOpenSeaMap ? setIsOpenSeaMap(false) : setIsOpenSeaMap(true)}

                            sx={isOpenSeaMap
                                ? {
                                    backgroundColor: '#F64A00', color: 'white', padding: 1,
                                    "&:hover": { backgroundColor: '#F64A00', color: 'lime' }
                                }
                                : {
                                    backgroundColor: '#CBCDBF', color: 'black', padding: 1,
                                    "&:hover": { backgroundColor: '#D2D7BA', color: 'black' }
                                }
                            }

                        >OpenSeaMap</Button>
                        <Button onClick={() => isPublicTransport ? setIsPublicTransport(false) : setIsPublicTransport(true)}

                            sx={isPublicTransport
                                ? {
                                    backgroundColor: '#F64A00', color: 'white', padding: 1,
                                    "&:hover": { backgroundColor: '#F64A00', color: 'lime' }
                                }
                                : {
                                    backgroundColor: '#CBCDBF', color: 'black', padding: 1,
                                    "&:hover": { backgroundColor: '#D2D7BA', color: 'black' }
                                }
                            }

                        >Public Transport</Button>

                    </Stack>

                </Grid>

            </Stack>
        </div>
    )
}

export default WeatherButton