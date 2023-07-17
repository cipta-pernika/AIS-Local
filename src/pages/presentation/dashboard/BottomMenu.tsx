import React, { FC } from 'react'
// eslint-disable-next-line import/no-extraneous-dependencies
import { isMobile } from 'react-device-detect';
import { Box, IconButton, Stack } from '@mui/material';
import Typography from '@mui/material/Typography';
import SettingsOutlinedIcon from '@mui/icons-material/SettingsOutlined';
import WbSunnyOutlinedIcon from '@mui/icons-material/WbSunnyOutlined';
import RestoreOutlinedIcon from '@mui/icons-material/RestoreOutlined';
import CameraAltOutlinedIcon from '@mui/icons-material/CameraAltOutlined';

interface IBottomMenuProps {
    handleClickSetting: any;
    handleClickWeather: any;
    handleClickFilter: any;
    handleClickCam: any;
    handleClickPlayback: any;
}
const BottomMenu: FC<IBottomMenuProps> = ({
    handleClickSetting, handleClickWeather, handleClickFilter,
    handleClickCam,
    handleClickPlayback }) => {
    return (
        <Stack spacing={0} direction='row' justifyContent='center'>

            <Box
                display="flex"
                width={450} height={70}
                bgcolor="#D2D7BA"
                border={0}
                borderRadius={5}
                justifyContent='center'
            // sx={{ opacity: 0.6 }}
            >
                <IconButton size='large'
                    // sx={{ "&:hover": { color: '#F64A00' } }}
                    onClick={handleClickSetting}
                >
                    <Stack spacing={0} display='flex' textAlign='center'>
                        <Typography variant="h6" className="title"
                            sx={{
                                color: 'black',
                                "&:hover": { color: '#F64A00' }
                            }}
                        >
                            <SettingsOutlinedIcon fontSize='large'
                            /><br />
                            Setting
                        </Typography>
                    </Stack>
                </IconButton>
                <IconButton
                    size='large'
                    style={{ backgroundColor: 'transparent' }}
                    onClick={handleClickWeather}
                >
                    <Stack spacing={0} display='flex' textAlign='center'>
                        <Typography variant="h6" className="title"
                            sx={{
                                color: 'black',
                                "&:hover": { color: '#F64A00' }
                            }}>
                            <WbSunnyOutlinedIcon fontSize='large' />
                            <br />
                            Weather
                        </Typography>
                        {/* <label style={{ color: 'black', fontSize: 16 }}>Weather</label> */}
                    </Stack>
                </IconButton>
                {
                    !isMobile &&
                    <IconButton size='large' onClick={handleClickCam}>
                        <Stack spacing={0} display='flex' textAlign='center'>
                            <Typography variant="h6" className="title"
                                sx={{
                                    color: 'black',
                                    "&:hover": { color: '#F64A00' }
                                }}>
                                <CameraAltOutlinedIcon fontSize='large' />
                                <br />
                                Camera
                            </Typography>
                        </Stack>
                    </IconButton>
                }
                <IconButton size='large' onClick={handleClickPlayback}>
                    <Stack spacing={0} display='flex' textAlign='center'>
                        <Typography variant="h6" className="title"
                            sx={{
                                color: 'black',
                                "&:hover": { color: '#F64A00' }
                            }}>
                            <RestoreOutlinedIcon fontSize='large' />
                            <br />
                            Playback
                        </Typography>
                        {/* <label style={{ color: 'black', fontSize: 16 }}>Playback</label> */}
                    </Stack>
                </IconButton>
                {/* </Box> */}
            </Box>
        </Stack>
    )
}

export default BottomMenu