import React, { useState } from 'react';
import { AppBar, IconButton, InputBase, Stack, Toolbar, alpha, styled } from '@mui/material';
import '../../../styles/MapStyles.css';
import Typography from '@mui/material/Typography';
import 'bootstrap/dist/css/bootstrap.min.css';
import MenuIcon from '@mui/icons-material/Menu';
import SearchIcon from '@mui/icons-material/Search';
import { isMobile } from 'react-device-detect';
import DrawerMap from './DrawerMap';
import Maps from '../../../components/Maps';
import logo from '../../../assets/img/logo3.png'
import ModalLoggers from './ModalLoggers';
import ModalSensors from './ModalSensors';
import ModalCam from './ModalCam';
import useDarkMode from '../../../hooks/useDarkMode';
import Button, { IButtonProps } from '../../../components/bootstrap/Button';
import Popovers from '../../../components/bootstrap/Popovers';
import PageWrapper from '../../../layout/PageWrapper/PageWrapper';
import ModalAis from './ModalAis';
import ModalAdsb from './ModalAdsb';
import ModalRadar from './ModalRadar';
import ModalUser from './ModalUser';

const Search = styled('div')(({ theme }) => ({
	position: 'relative',
	borderRadius: theme.shape.borderRadius,
	backgroundColor: alpha(theme.palette.common.white, 1),
	'&:hover': {
		backgroundColor: alpha(theme.palette.common.white, 0.5),
	},
	marginLeft: 0,
	width: '100%',
	[theme.breakpoints.up('sm')]: {
		marginLeft: theme.spacing(1),
		width: 300,
	}, color: 'black', height: 40
}));

const SearchIconWrapper = styled('div')(({ theme }) => ({
	padding: theme.spacing(0, 2),
	height: '100%',
	position: 'absolute',
	pointerEvents: 'none',
	display: 'flex',
	alignItems: 'center',
	justifyContent: 'center',
}));

const StyledInputBase = styled(InputBase)(({ theme }) => ({
	color: 'inherit',
	'& .MuiInputBase-input': {
		padding: theme.spacing(1, 1, 1, 0),

		// vertical padding + font size from searchIcon
		paddingLeft: `calc(1em + ${theme.spacing(4)})`,
		transition: theme.transitions.create('width'),
		width: '100%',
		[theme.breakpoints.up('sm')]: {
			width: '12ch',
			'&:focus': {
				width: '20ch',
			},
		},
	},
}));

const DashboardPage = () => {
	const [latitudeX, setLatitudeX] = useState(0);
	const [longitudeX, setLongitudeX] = useState(0);
	const [zoom, setZoom] = useState(11);

	const [isModal, setIsModal] = useState(false);
	const [isModal2, setIsModal2] = useState(true);
	const [isModal3, setIsModal3] = useState(true);
	const [isModal4, setIsModal4] = useState(false);
	const [isSetting, setIsSetting] = useState(false);
	const [isWeather, setIsWeather] = useState(false);
	const [isFilter, setIsFilter] = useState(false);
	const [isPlayback, setIsPlayback] = useState(false);
	const [isCam, setIsCam] = useState(false);
	// const [isReportBox, setIsReportBox] = useState<any>('hidden')
	const [isReportBox, setIsReportBox] = useState<boolean>(false)
	const [expanded2, setExpanded2] = React.useState<string | false>(false);

	// Layer
	const [isGoogleMap, setIsGoogleMap] = useState(false)
	const [isGoogleSatelite, setIsGoogleSatelite] = useState(false)
	const [isGoogleHybrid, setIsGoogleHybrid] = useState(false)
	const [isEsriWordStreet, setIsEsriWordStreet] = useState(false)
	const [isEsriTopographic, setIsEsriTopographic] = useState(false)
	const [isEsriOceanBasemap, setIsEsriOceanBasemap] = useState(false)
	const [isOpenStreetMap, setIsOpenStreetMap] = useState(false)

	const [isClouds, setIsClouds] = useState(false)
	const [isPrecipitation, setIsPrecipitation] = useState(false)
	const [isSealevelpressure, setIsSealevelpressure] = useState(false)
	const [isWindSpeed, setIsWindSpeed] = useState(false)
	const [isTemperature, setIsTemperature] = useState(false)
	const [isWindSpeedDirection, setIsWindSpeedDirection] = useState(false)
	const [isConvectiveprecipitation, setIsConvectiveprecipitation] = useState(false)
	const [isPrecipitationintensity, setIsPrecipitationintensity] = useState(false)
	const [isAccumulatedprecipitation, setIsAccumulatedprecipitation] = useState(false)
	const [isAccumulatedprecipitationrain, setIsAccumulatedprecipitationrain] = useState(false)
	const [isAccumulatedprecipitationsnow, setIsAccumulatedprecipitationsnow] = useState(false)
	const [isDepthofsnow, setIsDepthofsnow] = useState(false)
	const [isWindspeedaltitudeofmeters, setIsWindspeedaltitudeofmeters] = useState(false)
	const [isAtmosphericpressuremeansealevel, setIsAtmosphericpressuremeansealevel] = useState(false)
	const [isAirtemperatureatmeters, setIsAirtemperatureatmeters] = useState(false)
	const [isTemperatureofdewpoint, setIsTemperatureofdewpoint] = useState(false)
	const [isSoiltemperatureсm, setIsSoiltemperatureсm] = useState(false)
	const [isSoiltemperatureMoreсm, setIsSoiltemperatureMoreсm] = useState(false)
	const [isRelativehumidity, setIsRelativehumidity] = useState(false)
	const [isCloudiness, setIsCloudiness] = useState(false)
	const [isSignificantWaveHeight, setIsSignificantWaveHeight] = useState(false)
	const [isSeaCurrent, setIsSeaCurrent] = useState(false)

	const [isOpenSeaMap, setIsOpenSeaMap] = useState(false)
	const [isPublicTransport, setIsPublicTransport] = useState(false)
	const [isMeasure, setIsMeasure] = useState(true)
	const [isBoxLayer, setIsBoxLayer] = useState<any>('hidden')

	const [isOpenLoggers, setIsOpenLoggers] = useState(false)
	const [isOpenSensors, setIsOpenSensors] = useState(false)
	const [isOpenUsers, setIsOpenUsers] = useState(false)

	const [isAisList, setIsAisList] = useState(false)
	const [isAdsbList, setIsAdsbList] = useState(false)
	const [isRadarList, setIsRadarList] = useState(false)

	const [dataMmsi, setDataMmsi] = useState<any[]>([])
	const [dataPlayback, setDataPlayback] = useState<any[]>([])
	const [isRunPlayback, setIsRunPlayback] = useState(false)

	const [isLocalMap,setIsLocalMap]=useState(true)



	const handleClick = () => {
		if (!isModal) {
			setIsModal(true)
			setIsModal3(false)
		} else {
			setIsModal(false)
			setTimeout(() => {
				setIsModal(true)
			}, 500);
		}
		if (isSetting) {
			setIsSetting(false)
		}
		if (isWeather) {
			setIsWeather(false)
		}
		if (isFilter) {
			setIsFilter(false)
		}
		if (isCam) {
			setIsCam(false)
		}
		if (isPlayback) {
			setIsPlayback(false)
		}

	}

	const handleClick2 = () => {
		let openMeasure = ''
		if (localStorage.getItem('openMeasure')) {
			openMeasure = JSON.parse(localStorage.getItem("openMeasure") || '');
		}
		if (openMeasure === '') {
			if (expanded === 'panel1') {
				setExpanded(false)
			} else if (expanded2 === 'panel1') {
				setExpanded2(false)
				setIsModal3(true)
			} else if (isModal4) {
				setIsModal4(false)
			} else if (isModal) {
				setIsModal(false)
				// eslint-disable-next-line @typescript-eslint/no-unused-expressions
				isModal2 ?
					(setIsModal2(true), setIsModal3(true)
					) :
					(setIsModal2(false), setIsModal3(false)
						, setIsBoxLayer('hidden')
					)
			} else {
				// eslint-disable-next-line @typescript-eslint/no-unused-expressions
				isModal2 ?
					(setIsModal2(false), setIsModal3(false)
						, setIsBoxLayer('hidden')
					) :
					(setIsModal2(true), setIsModal3(true)
					);
				if ((isSetting || isWeather || isFilter ||
					isPlayback || isCam) && isModal2) {
					setIsSetting(false)
					setIsWeather(false)
					setIsFilter(false)
					setIsCam(false)
					setIsPlayback(false)
					setIsModal3(true)
					setIsModal2(true)
					setIsBoxLayer('hidden')
					// setIsLayer(true)
				}
			}
			if (isReportBox) {
				setIsReportBox(false)
			}
		} else {
			if (isModal2) {
				setIsModal2(false)
				setIsBoxLayer('hidden')
			}
			if (isModal3) {
				setIsModal3(false)
			}
		}
	}

	const handleClick3 = () => {
		isModal4 ? setIsModal4(false) : setIsModal4(true);
		if (isBoxLayer !== 'hidden') {
			setIsBoxLayer('hidden')
		}
	}

	const handleClickSetting = () => {
		if (isSetting) {
			setIsSetting(false)
			if (isModal2) {
				setIsModal3(true)
				setExpanded2(false)
			}
		} else {
			setIsSetting(true)
			if (isModal3) {
				setIsModal3(false)
			}
			if (isModal) {
				setIsModal(false)
			}
			if (isWeather) {
				setIsWeather(false)
			}
			if (isFilter) {
				setIsFilter(false)
			}
			if (isCam) {
				setIsCam(false)
			}
			if (isPlayback) {
				setIsPlayback(false)
			}
			setExpanded2(false)
		}
	}

	const handleClickWeather = () => {
		if (isWeather) {
			setIsWeather(false)
			if (isModal2) {
				setIsModal3(true)
				setExpanded2(false)
			}
		} else {
			setIsWeather(true)
			if (isModal3) {
				setIsModal3(false)
			}
			if (isModal) {
				setIsModal(false)
			}
			if (isSetting) {
				setIsSetting(false)
			}
			if (isFilter) {
				setIsFilter(false)
			}
			if (isCam) {
				setIsCam(false)
			}
			if (isPlayback) {
				setIsPlayback(false)
			}
			if (expanded2 === 'panel1') {
				setExpanded2(false)
			}

		}
	}

	const handleClickFilter = () => {
		if (isFilter) {
			setIsFilter(false)
			if (isModal2) {
				setIsModal3(true)
				setExpanded2(false)
			}
		} else {
			setIsFilter(true)
			if (isModal3) {
				setIsModal3(false)
			}
			if (isModal) {
				setIsModal(false)
			}
			if (isSetting) {
				setIsSetting(false)
			}
			if (isWeather) {
				setIsWeather(false)
			}
			if (isCam) {
				setIsCam(false)
			}
			if (isPlayback) {
				setIsPlayback(false)
			}
			if (expanded2 === 'panel1') {
				setExpanded2(false)
			}


		}
	}

	const handleClickPlayback = () => {
		if (isPlayback) {
			setIsPlayback(false)
			if (isModal2) {
				setIsModal3(true)
				setExpanded2(false)
			}
		} else {
			setIsPlayback(true)
			if (isModal3) {
				setIsModal3(false)
			}
			if (isModal) {
				setIsModal(false)
			}
			if (isSetting) {
				setIsSetting(false)
			}
			if (isFilter) {
				setIsFilter(false)
			}
			if (isCam) {
				setIsCam(false)
			}
			if (isWeather) {
				setIsWeather(false)
			}
			if (expanded2 === 'panel1') {
				setExpanded2(false)
			}
		}
	}

	const handleClickCam = () => {
		isCam ? setIsCam(false) : setIsCam(true)
	}

	const emptyLayer = () => {
		setIsGoogleMap(false)
		setIsGoogleSatelite(false)
		setIsGoogleHybrid(false)
		setIsEsriWordStreet(false)
		setIsEsriTopographic(false)
		setIsEsriOceanBasemap(false)
		setIsOpenStreetMap(false)
		setIsLocalMap(false)
	}
	const HandleLayerGoogleMap = () => {
		emptyLayer()
		setIsGoogleMap(true)
	}

	const HandleLayerGoogleSatelite = () => {
		emptyLayer()
		setIsGoogleSatelite(true)
	}

	const HandleLayerGoogleHybrid = () => {
		emptyLayer()
		setIsGoogleHybrid(true)
	}

	const HandleLayerEsriWordStreet = () => {
		emptyLayer()
		setIsEsriWordStreet(true)
	}
	const HandleLayerEsriTopographic = () => {
		emptyLayer()
		setIsEsriTopographic(true)
	}
	const HandleLayerEsriOceanBasemap = () => {
		emptyLayer()
		setIsEsriOceanBasemap(true)
	}
	const HandleLayerOpenStreetMap = () => {
		emptyLayer()
		setIsOpenStreetMap(true)
	}
	const HandleLocalMap = () => {
		emptyLayer()
		setIsLocalMap(true)
	}
	const handleReport = () => {
		isReportBox ? setIsReportBox(false) : setIsReportBox(true);
	}
	// const warna1 = '#c79392'
	// const warna2 = '#e57545'
	// const warna3 = '#d3d8bc'
	// const warna4='#393939'
	// const warna5='#4d4d4d'
	// const warna5='#D2D7BA'
	// const warna5='#CBCDBF'
	// const warna5='#DEDFDA'
	// const warna5='#F64A00'
	const [expanded, setExpanded] = React.useState<string | false>(false);


	const { darkModeStatus, setDarkModeStatus } = useDarkMode();
	const styledBtn: IButtonProps = {
		color: darkModeStatus ? 'dark' : 'light',
		hoverShadow: 'default',
		isLight: !darkModeStatus,
		size: 'lg',
	};


	return (
		<PageWrapper >
			<AppBar
				position="absolute"
				style={{
					background: 'transparent',
					boxShadow: 'none',
					top: 10
				}}
				elevation={0}>
				<Toolbar  >
					{
						!isMobile &&
						<img src={logo} alt="Logo"
							className='logo'
							width={80}
							style={{ position: 'absolute', top: 10, left: 20 }}
						/>
					}
					<Typography variant="h6" className="title" />
					<Stack spacing={2} direction='row'>
						<Search>
							<SearchIconWrapper>
								<SearchIcon />
							</SearchIconWrapper>
							<StyledInputBase
								placeholder="Search…"
								inputProps={{ 'aria-label': 'search' }}
							/>
						</Search>
						<div className='col-auto'>
							<Popovers trigger='hover' desc='Dark / Light mode'>
								<Button
									// eslint-disable-next-line react/jsx-props-no-spreading
									{...styledBtn}
									icon={darkModeStatus ? 'DarkMode' : 'LightMode'}
									onClick={() => setDarkModeStatus(!darkModeStatus)}
									aria-label='Toggle fullscreen'
									data-tour='dark-mode'
								/>
							</Popovers>
						</div>
						<IconButton
							size="large"
							edge="start"
							color="inherit"
							aria-label="open drawer"
							sx={{ mr: 2 }}
							onClick={handleClick3}
						>
							<MenuIcon fontSize='large' />
						</IconButton>

					</Stack>
				</Toolbar>

			</AppBar>
			<Maps
				latitudeX={latitudeX}
				setLatitudeX={setLatitudeX}
				longitudeX={longitudeX}
				setLongitudeX={setLongitudeX}
				zoom={zoom}
				setZoom={setZoom}

				handleClick2={handleClick2}
				isModal={isModal}
				handleClick={handleClick}
				isModal2={isModal2}
				isReportBox={isReportBox}
				setIsReportBox={setIsReportBox}
				handleReport={handleReport}
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
				isMeasure={isMeasure}
				setIsMeasure={setIsMeasure}
				isBoxLayer={isBoxLayer}

				HandleLayerGoogleMap={HandleLayerGoogleMap}
				HandleLayerGoogleSatelite={HandleLayerGoogleSatelite}
				HandleLayerGoogleHybrid={HandleLayerGoogleHybrid}
				HandleLayerOpenStreetMap={HandleLayerOpenStreetMap}
				HandleLayerEsriWordStreet={HandleLayerEsriWordStreet}
				HandleLayerEsriTopographic={HandleLayerEsriTopographic}
				HandleLayerEsriOceanBasemap={HandleLayerEsriOceanBasemap}
				HandleLocalMap={HandleLocalMap}

				setDataMmsi={setDataMmsi}
				dataPlayback={dataPlayback}
				isRunPlayback={isRunPlayback}
				setIsRunPlayback={setIsRunPlayback}
				isPlayback={isPlayback}

				dataMmsi={dataMmsi}
				setDataPlayback={setDataPlayback}
				handleClickPlayback={handleClickPlayback}

				isLocalMap={isLocalMap}
			/>
			<DrawerMap
				isModal3={isModal3}
				handleClick={handleClick}
				isModal2={isModal2}
				handleClickSetting={handleClickSetting}
				handleClickWeather={handleClickWeather}
				handleClickFilter={handleClickFilter}
				handleClickPlayback={handleClickPlayback}
				handleClickCam={handleClickCam}
				handleClick2={handleClick2}
				isModal4={isModal4}
				handleClick3={handleClick3}
				isSetting={isSetting}
				isWeather={isWeather}

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

				isBoxLayer={isBoxLayer}
				setIsBoxLayer={setIsBoxLayer}

				isOpenLoggers={isOpenLoggers}
				setIsOpenLoggers={setIsOpenLoggers}
				setIsModal4={setIsModal4}
				isOpenSensors={isOpenSensors}
				setIsOpenSensors={setIsOpenSensors}
				isOpenUsers={isOpenUsers}
				setIsOpenUsers={setIsOpenUsers}

				isAisList={isAisList}
				setIsAisList={setIsAisList}
				isAdsbList={isAdsbList}
				setIsAdsbList={setIsAdsbList}
				isRadarList={isRadarList}
				setIsRadarList={setIsRadarList}

			/>
			<ModalLoggers
				isOpen={isOpenLoggers}
				setIsOpen={setIsOpenLoggers}
			/>

			<ModalSensors
				isOpen={isOpenSensors}
				setIsOpen={setIsOpenSensors}
			/>

			<ModalCam
				isOpen={isCam}
				setIsOpen={setIsCam}
			/>

			<ModalAis
				isOpen={isAisList}
				setIsOpen={setIsAisList}
			/>

			<ModalAdsb
				isOpen={isAdsbList}
				setIsOpen={setIsAdsbList}
			/>

			<ModalRadar
				isOpen={isRadarList}
				setIsOpen={setIsRadarList}
			/>

			<ModalUser
				isOpen={isOpenUsers}
				setIsOpen={setIsOpenUsers}
			/>
		</PageWrapper>
	);
};

export default DashboardPage;
