import React, { useEffect } from 'react'
// eslint-disable-next-line import/no-extraneous-dependencies
import { useNavigate } from 'react-router';
import { Box, Stack, Typography, styled } from '@mui/material';
import ExpandMoreIcon from '@mui/icons-material/ExpandMore';
import ArrowForwardIosSharpIcon from '@mui/icons-material/ArrowForwardIosSharp';
import MuiAccordion, { AccordionProps } from '@mui/material/Accordion';
import MuiAccordionSummary, {
    AccordionSummaryProps,
} from '@mui/material/AccordionSummary';
import MuiAccordionDetails from '@mui/material/AccordionDetails';
import axios from "axios";
import dayjs from 'dayjs';
import utc from 'dayjs/plugin/utc';

dayjs.extend(utc)
// eslint-disable-next-line @typescript-eslint/no-unused-vars
let playbackTimer: ReturnType<typeof setTimeout>;

const Accordion = styled((props: AccordionProps) => (
    <MuiAccordion disableGutters elevation={0} square {...props} />
))(({ theme }) => ({
    border: `1px solid ${theme.palette.divider}`,
    '&:not(:last-child)': {
        borderBottom: 0,
    },
    '&:before': {
        display: 'none',
    },
}));

const AccordionSummary = styled((props: AccordionSummaryProps) => (
    <MuiAccordionSummary
        expandIcon={<ArrowForwardIosSharpIcon sx={{ fontSize: '0.9rem' }} />}
        {...props}
    />
))(({ theme }) => ({
    backgroundColor:
        theme.palette.mode === 'dark'
            ? 'rgba(255, 255, 255, .05)'
            : 'rgba(0, 0, 0, .03)',
    flexDirection: 'row-reverse',
    '& .MuiAccordionSummary-expandIconWrapper.Mui-expanded': {
        transform: 'rotate(90deg)',
    },
    '& .MuiAccordionSummary-content': {
        marginLeft: theme.spacing(1),
    },
}));

const AccordionDetails = styled(MuiAccordionDetails)(({ theme }) => ({
    padding: theme.spacing(2),
    borderTop: '1px solid rgba(0, 0, 0, .125)',
}));

const AccordionMap = () => {

    const [expanded, setExpanded] = React.useState<string | false>(false);
    const [livefeed, setLivefeed] = React.useState<any>(null);
    const [livefeedAdsb, setLivefeedAdsb] = React.useState<any>(null);
    const Token = `Bearer ${localStorage.getItem('token')}`

    const history = useNavigate()

    const handleChange =
        (panel: string) => (event: React.SyntheticEvent, newExpanded: boolean) => {
            setExpanded(newExpanded ? panel : false);
        };

    const getLiveFeed = () => {
        try {
            axios
                .get(`${process.env.REACT_APP_URL_LIVEFEED}`,
                    {
                        headers: {
                            'Authorization': Token
                        }
                    }
                )
                .then((response) => {
                    if (response.status === 201) {
                        setLivefeed(response.data.message);
                        setLivefeedAdsb(response.data.liveadsb)
                    } 
                    
                    if(response.data.message==='Not authenticated'){
                        localStorage.removeItem('token')
                        history('/auth-pages/login')

                    }
                })
        } catch (error) {
            console.log(error);
            localStorage.removeItem('token')
            history('/auth-pages/login')
}
    }

    useEffect(() => {
        playbackTimer = setInterval(getLiveFeed, 60000);
        // eslint-disable-next-line react-hooks/exhaustive-deps
    }, []);

    return (
        <>
            {/* <Stack spacing={1}> */}

            <Accordion
                sx={{
                    width: 300,
                    borderRadius: 3,
                    background: 'transparent'
                }}
                elevation={5}
                expanded={expanded === 'panel1'}
                onChange={handleChange('panel1')}

            >
                <AccordionSummary
                    expandIcon={<ExpandMoreIcon fontSize='large'
                    />}
                    aria-controls="panel1a-content"
                    id="panel1a-header"
                    sx={{
                        color: 'black',
                        borderRadius: 3,
                        height: 30,
                        backgroundColor: '#D2D7BA',
                        // backgroundColor: 'black'
                    }}
                >
                    <Typography>Live Feed AIS</Typography>
                </AccordionSummary>
                <AccordionDetails

                    sx={{
                        backgroundColor: '#DEDFDA',
                        justifyContent: 'center',
                        maxHeight: 200,
                        overflowY: 'scroll',
                        borderRadius: 3,
                        // mt: 1
                    }}
                >
                    <Stack spacing={1} >
                        {Array.isArray(livefeed) && livefeed.map((item) => (
                            <Box borderRadius={3} width={270} height={170} sx={{ backgroundColor: '#CBCDBF', padding: 2 }}>
                                <Stack direction="row">
                                    <Typography className="title1">{item.id}. {item?.sensor_data?.sensor?.name}</Typography>
                                    <Typography color="#F64A00" className="title2">{item.vessel?.mmsi}</Typography>
                                </Stack>
                                <table className='table-auto' style={{ color: 'black' }}>
                                    <tbody>
                                        <tr>
                                            <td className='font-bold'>Name</td>
                                            <td>:{item.vessel.vessel_name}</td>
                                        </tr>
                                        <tr>
                                            <td className='font-bold'>IMO</td>
                                            <td>:{item.vessel.imo}</td>
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
                                            <td className='font-bold'>Callsign</td>
                                            <td>:{item.vessel.callsign}</td>
                                        </tr>
                                        <tr>
                                            <td className='font-bold'>Timestamp</td>
                                            <td>:{dayjs.utc(item.timestamp, 'YYYY-MM-DD HH:mm:ss',).local().format('DD MMM YYYY, HH:mm:ss')}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </Box>
                        ))}

                    </Stack>

                </AccordionDetails>
            </Accordion>
            <br />
            <Accordion
                sx={{
                    width: 300,
                    borderRadius: 3,
                    background: 'transparent'
                }}
                elevation={5}
                expanded={expanded === 'panel2'}
                onChange={handleChange('panel2')}

            >
                <AccordionSummary
                    expandIcon={<ExpandMoreIcon fontSize='large'
                    />}
                    aria-controls="panel1a-content"
                    id="panel1a-header"
                    sx={{
                        color: 'black',
                        borderRadius: 3,
                        height: 30,
                        backgroundColor: '#D2D7BA',
                        // backgroundColor: 'black'
                    }}
                >
                    <Typography>Live Feed ADSB</Typography>
                </AccordionSummary>
                <AccordionDetails

                    sx={{
                        backgroundColor: '#DEDFDA',
                        justifyContent: 'center',
                        maxHeight: 200,
                        overflowY: 'scroll',
                        borderRadius: 3,
                        // mt: 1
                    }}
                >
                    <Stack spacing={1} >
                        {Array.isArray(livefeedAdsb) && livefeedAdsb.map((item) => (
                            <Box borderRadius={3} width={270} height={170} sx={{ backgroundColor: '#CBCDBF', padding: 2 }}>
                                <Stack direction="row">
                                    <Typography className="title1">{item?.aircraft_id}</Typography>
                                    <Typography color="#F64A00" className="title2">{item.aircraft.hex_ident}</Typography>
                                </Stack>
                                <table className='table-auto' style={{ color: 'black' }}>
                                    <tbody>
                                        <tr>
                                            <td className='font-bold'>aircraft_id</td>
                                            <td>:{item.aircraft_id}</td>
                                        </tr>
                                        <tr>
                                            <td className='font-bold'>altitude</td>
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
                                            <td className='font-bold'>ground_speed</td>
                                            <td>:{item.ground_speed}</td>
                                        </tr>
                                        <tr>
                                            <td className='font-bold'>Timestamp</td>
                                            <td>:{dayjs.utc(item.timestamp, 'YYYY-MM-DD HH:mm:ss',).local().format('DD MMM YYYY, HH:mm:ss')}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </Box>
                        ))}

                    </Stack>

                </AccordionDetails>
            </Accordion>

            {/* <br />
            <Accordion
                square={false}
                sx={{
                    width: 300,
                    borderRadius: 3,
                    background: 'transparent'
                }}
                elevation={5}
                expanded={expanded === 'panel2'} onChange={handleChange('panel2')}
            >
                <AccordionSummary
                    expandIcon={<ExpandMoreIcon fontSize='large'
                    />}
                    aria-controls="panel1a-content"
                    id="panel1a-header"
                    sx={{
                        color: 'black',
                        borderRadius: 3,
                        height: 30,
                        backgroundColor: '#D2D7BA',
                    }}
                >
                    <Typography>Airport Disruptions</Typography>
                </AccordionSummary>
                <AccordionDetails

                    sx={{
                        backgroundColor: '#DEDFDA',
                        justifyContent: 'center',
                        maxHeight: 200,
                        overflowY: 'scroll',
                        borderRadius: 3,
                        // mt: 1
                    }}
                >
                    <Stack spacing={1} >
                        <Box borderRadius={3} width={270} height={50}
                            sx={{
                                backgroundColor: '#CBCDBF', padding: 2,
                                // mt: 1 
                            }}>
                            <Stack direction='row'>
                                <Typography className='title1'>1. Test</Typography>
                                <Typography color='#F64A00' className='title2' >Test</Typography>
                            </Stack>
                        </Box>
                        <Box borderRadius={3} width={270} height={50}
                            sx={{ backgroundColor: '#CBCDBF', padding: 2 }}>
                            <Stack direction='row'>
                                <Typography className='title1'>1. Test</Typography>
                                <Typography color='#F64A00' className='title2' >Test</Typography>
                            </Stack>
                        </Box>
                        <Box borderRadius={3} width={270} height={50}
                            sx={{ backgroundColor: '#CBCDBF', padding: 2 }}>
                            <Stack direction='row'>
                                <Typography className='title1'>1. Test</Typography>
                                <Typography color='#F64A00' className='title2' >Test</Typography>
                            </Stack>
                        </Box>
                        <Box borderRadius={3} width={270} height={50}
                            sx={{ backgroundColor: '#CBCDBF', padding: 2 }}>
                            <Stack direction='row'>
                                <Typography className='title1'>1. Test</Typography>
                                <Typography color='#F64A00' className='title2' >Test</Typography>
                            </Stack>
                        </Box>
                    </Stack>

                </AccordionDetails>
            </Accordion>
            <br />
            <Accordion
                square={false}
                sx={{
                    width: 300,
                    borderRadius: 3,
                    background: 'transparent'
                }}
                elevation={5}
                expanded={expanded === 'panel3'} onChange={handleChange('panel3')}
            >
                <AccordionSummary
                    expandIcon={<ExpandMoreIcon fontSize='large'
                    />}
                    aria-controls="panel1a-content"
                    id="panel1a-header"
                    sx={{
                        color: 'black',
                        borderRadius: 3,
                        height: 30,
                        backgroundColor: '#D2D7BA',
                    }}
                >
                    <Typography>Bookmarks</Typography>
                </AccordionSummary>
                <AccordionDetails

                    sx={{
                        backgroundColor: '#DEDFDA',
                        justifyContent: 'center',
                        maxHeight: 200,
                        overflowY: 'scroll',
                        borderRadius: 3,
                        // mt: 1
                    }}
                >
                    <Stack spacing={1} >
                        <Box borderRadius={3} width={270} height={50}
                            sx={{ backgroundColor: '#CBCDBF', padding: 2, mt: 0 }}>
                            <Stack direction='row'>
                                <Typography className='title1'>1. Test</Typography>
                                <Typography color='#F64A00' className='title2' >Test</Typography>
                            </Stack>
                        </Box>
                        <Box borderRadius={3} width={270} height={50}
                            sx={{ backgroundColor: '#CBCDBF', padding: 2 }}>
                            <Stack direction='row'>
                                <Typography className='title1'>1. Test</Typography>
                                <Typography color='#F64A00' className='title2' >Test</Typography>
                            </Stack>
                        </Box>
                        <Box borderRadius={3} width={270} height={50}
                            sx={{ backgroundColor: '#CBCDBF', padding: 2 }}>
                            <Stack direction='row'>
                                <Typography className='title1'>1. Test</Typography>
                                <Typography color='#F64A00' className='title2' >Test</Typography>
                            </Stack>
                        </Box>
                        <Box borderRadius={3} width={270} height={50}
                            sx={{ backgroundColor: '#CBCDBF', padding: 2 }}>
                            <Stack direction='row'>
                                <Typography className='title1'>1. Test</Typography>
                                <Typography color='#F64A00' className='title2' >Test</Typography>
                            </Stack>
                        </Box>
                    </Stack>

                </AccordionDetails>
            </Accordion> */}

            {/* </Stack> */}

        </>

    )
}

export default AccordionMap