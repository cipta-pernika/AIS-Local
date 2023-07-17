import { Accordion, AccordionDetails, AccordionSummary, Button, Grid, Stack, Typography } from '@mui/material'
import React, { FC } from 'react'
import ExpandMoreIcon from '@mui/icons-material/ExpandMore';

interface IAccordProps {
    expanded: any;
    handleChange: any;
    titleView2: string;
    titleView: string;
    HandleLayerGoogleMap: any;
    isGoogleMap: boolean;
    HandleLayerGoogleSatelite: any;
    isGoogleSatelite: boolean;
    HandleLayerGoogleHybrid: any;
    isGoogleHybrid: boolean;
    HandleLayerOpenStreetMap: any;
    isOpenStreetMap: boolean;
    HandleLayerEsriWordStreet: any;
    isEsriWordStreet: boolean;
    HandleLayerEsriTopographic: any;
    isEsriTopographic: boolean;
    HandleLayerEsriOceanBasemap: any;
    isEsriOceanBasemap: boolean;
    HandleViewMulti: any;
    isMulti: boolean;
    HandleViewRadar: any;
    isRadar: boolean;
    HandleViewMap: any;
    isMap: boolean;
}
const AccordLayerView: FC<IAccordProps> = ({
    expanded, handleChange,
    titleView2, titleView,
    HandleLayerGoogleMap, isGoogleMap,
    HandleLayerGoogleSatelite, isGoogleSatelite,
    HandleLayerGoogleHybrid, isGoogleHybrid,
    HandleLayerOpenStreetMap, isOpenStreetMap,
    HandleLayerEsriWordStreet, isEsriWordStreet,
    HandleLayerEsriTopographic, isEsriTopographic,
    HandleLayerEsriOceanBasemap, isEsriOceanBasemap,
    HandleViewMulti, isMulti,
    HandleViewRadar, isRadar,
    HandleViewMap, isMap
}) => {
    return (
        <div>
            <Accordion
                sx={{
                    width: 'auto',
                    background: 'transparent'
                }}
                elevation={5}
                expanded={expanded === 'panel1'}
                onChange={handleChange('panel1')}

            >
                <AccordionSummary
                    expandIcon={<ExpandMoreIcon fontSize='large'
                        sx={{ color: 'white' }}
                    />}
                    aria-controls="panel1a-content"
                    id="panel1a-header"
                    sx={{
                        color: 'white',
                        borderRadius: 3,
                        height: 30,
                        // backgroundColor: '#D2D7BA',
                        backgroundColor: 'black'
                    }}
                >
                    <Typography className='title'>
                        <Stack direction='row'>
                            LAYER &nbsp; <div style={{ color: 'yellow' }}> {titleView2}</div>
                            &nbsp;&nbsp;VIEW &nbsp; <div style={{ color: 'yellow' }}> {titleView}</div>
                        </Stack>
                    </Typography>
                </AccordionSummary>
                <AccordionDetails

                    sx={{
                        backgroundColor: 'black',
                        justifyContent: 'center',
                        // maxHeight: 200,
                        // overflowY: 'scroll',
                        borderRadius: 3,
                        mt: 1,
                        position: 'fixed',
                        width: 450,
                        right: 10
                    }}

                >
                    <Grid container
                    >
                        <Stack spacing={1} direction='row'>
                            <Grid xs={4}>

                                <Typography variant='h6' className='title'
                                    sx={{ color: 'white' }}>
                                    Google</Typography>
                                <Stack spacing={1} mt={1}>
                                    <Button onClick={HandleLayerGoogleMap}

                                        sx={isGoogleMap
                                            ? {
                                                backgroundColor: '#F64A00', color: 'white', padding: 1,
                                                "&:hover": { backgroundColor: 'yellow', color: 'black' }
                                            }
                                            : {
                                                backgroundColor: '#CBCDBF', color: 'black', padding: 1,
                                                "&:hover": { backgroundColor: 'yellow', color: 'black' }
                                            }
                                        }

                                    >Google Map</Button>
                                    <Button onClick={HandleLayerGoogleSatelite}
                                        sx={isGoogleSatelite
                                            ? {
                                                backgroundColor: '#F64A00', color: 'white', padding: 1,
                                                "&:hover": { backgroundColor: 'yellow', color: 'black' }
                                            }
                                            : {
                                                backgroundColor: '#CBCDBF', color: 'black', padding: 1,
                                                "&:hover": { backgroundColor: 'yellow', color: 'black' }
                                            }
                                        }
                                        fullWidth
                                    >Google Satelite</Button>
                                    <Button onClick={HandleLayerGoogleHybrid}
                                        sx={isGoogleHybrid
                                            ? {
                                                backgroundColor: '#F64A00', color: 'white', padding: 1,
                                                "&:hover": { backgroundColor: 'yellow', color: 'black' }
                                            }
                                            : {
                                                backgroundColor: '#CBCDBF', color: 'black', padding: 1,
                                                "&:hover": { backgroundColor: 'yellow', color: 'black' }
                                            }
                                        }
                                        fullWidth
                                    >Google Hybrid</Button>
                                    <Typography variant='h6' className='title'
                                        sx={{ color: 'white' }}>
                                        Open Street Map</Typography>
                                    <Button onClick={HandleLayerOpenStreetMap}
                                        sx={isOpenStreetMap
                                            ? {
                                                backgroundColor: '#F64A00', color: 'white', padding: 1,
                                                "&:hover": { backgroundColor: 'yellow', color: 'black' }
                                            }
                                            : {
                                                backgroundColor: '#CBCDBF', color: 'black', padding: 1,
                                                "&:hover": { backgroundColor: 'yellow', color: 'black' }
                                            }
                                        }
                                        fullWidth
                                    >Open Street Map</Button>

                                </Stack>


                            </Grid>
                            <Grid xs={4}>
                                <Typography variant='h6' className='title'
                                    sx={{ color: 'white' }}>
                                    Esri</Typography>
                                <Stack spacing={1} mt={1}>
                                    <Button onClick={HandleLayerEsriWordStreet}

                                        sx={isEsriWordStreet
                                            ? {
                                                backgroundColor: '#F64A00', color: 'white', padding: 1,
                                                "&:hover": { backgroundColor: 'yellow', color: 'black' }
                                            }
                                            : {
                                                backgroundColor: '#CBCDBF', color: 'black', padding: 1,
                                                "&:hover": { backgroundColor: 'yellow', color: 'black' }
                                            }
                                        }

                                    >Esri World Street</Button>
                                    <Button onClick={HandleLayerEsriTopographic}
                                        sx={isEsriTopographic
                                            ? {
                                                backgroundColor: '#F64A00', color: 'white', padding: 1,
                                                "&:hover": { backgroundColor: 'yellow', color: 'black' }
                                            }
                                            : {
                                                backgroundColor: '#CBCDBF', color: 'black', padding: 1,
                                                "&:hover": { backgroundColor: 'yellow', color: 'black' }
                                            }
                                        }
                                        fullWidth
                                    >Esri Topographic</Button>
                                    <Button onClick={HandleLayerEsriOceanBasemap}
                                        sx={isEsriOceanBasemap
                                            ? {
                                                backgroundColor: '#F64A00', color: 'white', padding: 1,
                                                "&:hover": { backgroundColor: 'yellow', color: 'black' }
                                            }
                                            : {
                                                backgroundColor: '#CBCDBF', color: 'black', padding: 1,
                                                "&:hover": { backgroundColor: 'yellow', color: 'black' }
                                            }
                                        }
                                        fullWidth
                                    >Esri Ocean Basemap</Button>
                                </Stack>

                            </Grid>
                            <Grid xs={4}>
                                <Typography variant='h6' className='title' sx={{ color: 'white' }}>
                                    Map Views</Typography>
                                <Stack spacing={1} mt={1}>
                                    <Button onClick={HandleViewMap}

                                        sx={isMap
                                            ? {
                                                backgroundColor: '#F64A00', color: 'white', padding: 1,
                                                "&:hover": { backgroundColor: 'yellow', color: 'black' }
                                                , width: 130
                                            }
                                            : {
                                                backgroundColor: '#CBCDBF', color: 'black', padding: 1,
                                                "&:hover": { backgroundColor: 'yellow', color: 'black' }
                                                , width: 130
                                            }
                                        }

                                    >Map(Default)</Button>
                                    <Button onClick={HandleViewMulti}

                                        sx={isMulti
                                            ? {
                                                backgroundColor: '#F64A00', color: 'white', padding: 1,
                                                "&:hover": { backgroundColor: 'yellow', color: 'black' }
                                                , width: 130
                                            }
                                            : {
                                                backgroundColor: '#CBCDBF', color: 'black', padding: 1,
                                                "&:hover": { backgroundColor: 'yellow', color: 'black' }
                                                , width: 130
                                            }
                                        }

                                    >Multi-Select</Button>

                                    <Button onClick={HandleViewRadar}

                                        sx={isRadar
                                            ? {
                                                backgroundColor: '#F64A00', color: 'white', padding: 1,
                                                "&:hover": { backgroundColor: 'yellow', color: 'black' }
                                                , width: 130
                                            }
                                            : {
                                                backgroundColor: '#CBCDBF', color: 'black', padding: 1,
                                                "&:hover": { backgroundColor: 'yellow', color: 'black' }
                                                , width: 130
                                            }
                                        }

                                    >Radar</Button>

                                </Stack>
                            </Grid>

                        </Stack>
                    </Grid>



                </AccordionDetails>
            </Accordion></div>
    )
}

export default AccordLayerView