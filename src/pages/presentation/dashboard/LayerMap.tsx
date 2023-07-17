import React, { FC } from 'react'
import { TileLayer, FeatureGroup, LayersControl } from 'react-leaflet';

const { Overlay, BaseLayer } = LayersControl;
interface ILayerProps {
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
    isLocalMap:boolean;
}
const LayerMap: FC<ILayerProps> = ({
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
    isLocalMap
}) => {
    return (
        <div>
            <LayersControl position='bottomleft' >
                <BaseLayer name='Google Maps' checked={isGoogleMap}>
                    <FeatureGroup>
                        <TileLayer key={0} url='https://mt1.google.com/vt/lyrs=r&x={x}&y={y}&z={z}' />
                    </FeatureGroup>
                </BaseLayer>
                <BaseLayer name='Google Satellite' checked={isGoogleSatelite}>
                    <FeatureGroup>
                        <TileLayer url='https://mt1.google.com/vt/lyrs=s&x={x}&y={y}&z={z}' />
                    </FeatureGroup>
                </BaseLayer>
                <BaseLayer name='Google Hybrid' checked={isGoogleHybrid}>
                    <FeatureGroup>
                        <TileLayer url='https://mt1.google.com/vt/lyrs=y&x={x}&y={y}&z={z}' />
                    </FeatureGroup>
                </BaseLayer>
                <BaseLayer name='Esri World Street' checked={isEsriWordStreet}>
                    <FeatureGroup>
                        <TileLayer url='https://services.arcgisonline.com/ArcGIS/rest/services/World_Street_Map/MapServer/tile/{z}/{y}/{x}' />
                    </FeatureGroup>
                </BaseLayer>
                <BaseLayer name='Esri Topographic' checked={isEsriTopographic}>
                    <FeatureGroup>
                        <TileLayer url='https://services.arcgisonline.com/ArcGIS/rest/services/World_Topo_Map/MapServer/tile/{z}/{y}/{x}' />
                    </FeatureGroup>
                </BaseLayer>
                <BaseLayer name='Esri Ocean BaseMap' checked={isEsriOceanBasemap}>
                    <FeatureGroup>
                        <TileLayer url='https://server.arcgisonline.com/ArcGIS/rest/services/Ocean_Basemap/MapServer/tile/{z}/{y}/{x}' />
                    </FeatureGroup>
                </BaseLayer>
                <BaseLayer name='Open Street Maps' checked={isOpenStreetMap}>
                    <TileLayer url='https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png' />
                </BaseLayer>
                <BaseLayer name='Local Maps' checked={isLocalMap}>
                    <TileLayer url='http://localhost:8080/tile/{z}/{x}/{y}.png' />
                </BaseLayer>
                <LayersControl.Overlay name='Feature group'>
                    <Overlay name='Clouds' checked={isClouds}>
                        <FeatureGroup>
                            <TileLayer url='https://tile.openweathermap.org/map/clouds_new/{z}/{x}/{y}.png?appid=6b33f16dae3587630c60ee15fcb0b4e4' />
                        </FeatureGroup>
                    </Overlay>
                    <Overlay name='Precipitation' checked={isPrecipitation}>
                        <FeatureGroup >
                            <TileLayer url='https://tile.openweathermap.org/map/precipitation_new/{z}/{x}/{y}.png?appid=6b33f16dae3587630c60ee15fcb0b4e4' />
                        </FeatureGroup>
                    </Overlay>
                    <Overlay name='Sea level pressure' checked={isSealevelpressure}>
                        <FeatureGroup >
                            <TileLayer url='https://tile.openweathermap.org/map/pressure_new/{z}/{x}/{y}.png?appid=6b33f16dae3587630c60ee15fcb0b4e4' />
                        </FeatureGroup>
                    </Overlay>
                    <Overlay name='Wind Speed' checked={isWindSpeed}>
                        <FeatureGroup >
                            <TileLayer url='https://tile.openweathermap.org/map/wind_new/{z}/{x}/{y}.png?appid=6b33f16dae3587630c60ee15fcb0b4e4' />
                        </FeatureGroup>
                    </Overlay>
                    <Overlay name='Temperature' checked={isTemperature}>
                        <FeatureGroup >
                            <TileLayer url='https://tile.openweathermap.org/map/temp_new/{z}/{x}/{y}.png?appid=6b33f16dae3587630c60ee15fcb0b4e4' />
                        </FeatureGroup>
                    </Overlay>
                    <Overlay name='Wind Speed & Direction' checked={isWindSpeedDirection}>
                        <FeatureGroup >
                            <TileLayer url='https://maps.openweathermap.org/maps/2.0/weather/WND/{z}/{x}/{y}?appid=481529c74b088da6f342f34aec3ed43d' />
                        </FeatureGroup>
                    </Overlay>
                    <Overlay name='Convective precipitation' checked={isConvectiveprecipitation}>
                        <FeatureGroup >
                            <TileLayer url='https://maps.openweathermap.org/maps/2.0/weather/PAC0/{z}/{x}/{y}?appid=481529c74b088da6f342f34aec3ed43d' />
                        </FeatureGroup>
                    </Overlay>
                    <Overlay name='Precipitation intensity' checked={isPrecipitationintensity}>
                        <FeatureGroup >
                            <TileLayer url='https://maps.openweathermap.org/maps/2.0/weather/PR0/{z}/{x}/{y}?appid=481529c74b088da6f342f34aec3ed43d' />
                        </FeatureGroup>
                    </Overlay>
                    <Overlay name='Accumulated precipitation' checked={isAccumulatedprecipitation}>
                        <FeatureGroup >
                            <TileLayer url='https://maps.openweathermap.org/maps/2.0/weather/PA0/{z}/{x}/{y}?appid=481529c74b088da6f342f34aec3ed43d' />
                        </FeatureGroup>
                    </Overlay>
                    <Overlay name='Accumulated precipitation - rain' checked={isAccumulatedprecipitationrain}>
                        <FeatureGroup >
                            <TileLayer url='https://maps.openweathermap.org/maps/2.0/weather/PAR0/{z}/{x}/{y}?appid=481529c74b088da6f342f34aec3ed43d' />
                        </FeatureGroup>
                    </Overlay>
                    <Overlay name='Accumulated precipitation - snow' checked={isAccumulatedprecipitationsnow}>
                        <FeatureGroup >
                            <TileLayer url='https://maps.openweathermap.org/maps/2.0/weather/PAS0/{z}/{x}/{y}?appid=481529c74b088da6f342f34aec3ed43d' />
                        </FeatureGroup>
                    </Overlay>
                    <Overlay name='Depth of snow' checked={isDepthofsnow}>
                        <FeatureGroup >
                            <TileLayer url='https://maps.openweathermap.org/maps/2.0/weather/SD0/{z}/{x}/{y}?appid=481529c74b088da6f342f34aec3ed43d' />
                        </FeatureGroup>
                    </Overlay>
                    <Overlay name='Wind speed altitude of 10 meters' checked={isWindspeedaltitudeofmeters}>
                        <FeatureGroup >
                            <TileLayer url='https://maps.openweathermap.org/maps/2.0/weather/WS10/{z}/{x}/{y}?appid=481529c74b088da6f342f34aec3ed43d' />
                        </FeatureGroup>
                    </Overlay>
                    <Overlay name='Atmospheric pressure mean sea level' checked={isAtmosphericpressuremeansealevel}>
                        <FeatureGroup >
                            <TileLayer url='https://maps.openweathermap.org/maps/2.0/weather/APM/{z}/{x}/{y}?appid=481529c74b088da6f342f34aec3ed43d' />
                        </FeatureGroup>
                    </Overlay>
                    <Overlay name='Air temperature at 2 meters' checked={isAirtemperatureatmeters}>
                        <FeatureGroup >
                            <TileLayer url='https://maps.openweathermap.org/maps/2.0/weather/TA2/{z}/{x}/{y}?appid=481529c74b088da6f342f34aec3ed43d' />
                        </FeatureGroup>
                    </Overlay>
                    <Overlay name='Temperature of dew point' checked={isTemperatureofdewpoint}>
                        <FeatureGroup >
                            <TileLayer url='https://maps.openweathermap.org/maps/2.0/weather/TD2/{z}/{x}/{y}?appid=481529c74b088da6f342f34aec3ed43d' />
                        </FeatureGroup>
                    </Overlay>
                    <Overlay name='Soil temperature 0-10 сm' checked={isSoiltemperatureсm}>
                        <FeatureGroup >
                            <TileLayer url='https://maps.openweathermap.org/maps/2.0/weather/TS0/{z}/{x}/{y}?appid=481529c74b088da6f342f34aec3ed43d' />
                        </FeatureGroup>
                    </Overlay>
                    <Overlay name='Soil temperature > 10 сm' checked={isSoiltemperatureMoreсm}>
                        <FeatureGroup >
                            <TileLayer url='https://maps.openweathermap.org/maps/2.0/weather/TS10/{z}/{x}/{y}?appid=481529c74b088da6f342f34aec3ed43d' />
                        </FeatureGroup>
                    </Overlay>
                    <Overlay name='Relative humidity' checked={isRelativehumidity}>
                        <FeatureGroup >
                            <TileLayer url='https://maps.openweathermap.org/maps/2.0/weather/HRD0/{z}/{x}/{y}?appid=481529c74b088da6f342f34aec3ed43d' />
                        </FeatureGroup>
                    </Overlay>
                    <Overlay name='Cloudiness' checked={isCloudiness}>
                        <FeatureGroup >
                            <TileLayer url='https://maps.openweathermap.org/maps/2.0/weather/CL/{z}/{x}/{y}?appid=481529c74b088da6f342f34aec3ed43d' />
                        </FeatureGroup>
                    </Overlay>
                    <Overlay name='Significant Wave Height' checked={isSignificantWaveHeight}>
                        <FeatureGroup >
                            <TileLayer url='https://peta-maritim.bmkg.go.id/api21/mpl_req/w3g_hires/swh/0/202301130000/202301131800/{z}/{x}/{y}.png?ci=1&overlays=,contourf&conc=snow' />
                        </FeatureGroup>
                    </Overlay>
                    <Overlay name='Sea Current' checked={isSeaCurrent}>
                        <FeatureGroup >
                            <TileLayer url='https://peta-maritim.bmkg.go.id/api21/mpl_req/inaflows/c/0/202301120000/202301131800/{z}/{x}/{y}.png?ci=1&overlays=,contourf&conc=snow' />
                        </FeatureGroup>
                    </Overlay>
                </LayersControl.Overlay>
                <LayersControl.Overlay name='Feature group 2' >
                    <Overlay name='OpenSeaMap' checked={isOpenSeaMap}>
                        <FeatureGroup >
                            <TileLayer url='https://tiles.openseamap.org/seamark/{z}/{x}/{y}.png' />
                        </FeatureGroup>
                    </Overlay>
                    <Overlay name='Public Transport' checked={isPublicTransport}>
                        <FeatureGroup >
                            <TileLayer url='https://tileserver.memomaps.de/tilegen/{z}/{x}/{y}.png' />
                        </FeatureGroup>
                    </Overlay>
                </LayersControl.Overlay>
            </LayersControl>

        </div>
    )
}

export default LayerMap