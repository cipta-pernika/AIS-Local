import { Box, Modal } from '@mui/material';
import React, { FC, useState } from 'react'
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';
import {
    faStopCircle,
    faHandSparkles,
    faToggleOff,
    faToggleOn,
    faPlus,
    faMinus,
    faBars,
    faMousePointer,
    faCircle,
    faArrowUp,
    faArrowLeft,
    faBan,
    faSyncAlt,
    faArrowRight,
    faArrowDown,
    faRadiation,
    faCompress,
    faRadiationAlt,
    faExpand
} from '@fortawesome/free-solid-svg-icons';
import axios from 'axios';
import '../../../styles/Cam.css'

// const CAM_URL = 'https://cctv.jabarprov.go.id/zm/cgi-bin/nph-zms?monitor=28&amp;user=view&amp;pass=view123'
const CAM_URL = process.env.REACT_APP_URL_CAM

const style = {
    position: 'absolute' as 'absolute',
    top: '50%',
    left: '50%',
    transform: 'translate(-50%, -50%)',
    width: 1000,
    // bgcolor: 'background.paper',
    bgcolor: 'black',
    border: '2px solid #000',
    boxShadow: 24,
    p: 4,
    '&:hover': { backgroundColor: 'black', color: 'white', cursor: 'default' },
    borderRadius: 3,
    padding: 2,
    color: 'white'
};

const API_BASE = 'http://localhost:8000/api/'
// const API_BASE = 'https://siege.cakrawala.id/api/'
const Token = 'Bearer 3|hE5MQU55jnea01RL1hJMUmk6F8uMr7QlNjz4gAHD'

interface ICamProps {
    isOpen: boolean;
    setIsOpen(...args: unknown[]): unknown;
}
const ModalCam: FC<ICamProps> = ({
    isOpen, setIsOpen
}) => {
    const [wipers, setWipers] = useState(false);
    const [autopans, setAutopans] = useState(false);
    const [continuesMode, setContinuesMode] = useState(false);
    const [imgError, setImgError] = useState(false)
    const [imgSelect, setImgSelect] = useState(CAM_URL)

    const handleControl = async (ctrl: number) => {
        let namaUrl: string = ''
        switch (ctrl) {
            case 1:
                namaUrl = 'camzoomminus'
                break
            case 2:
                namaUrl = 'camzoomminuscon'
                break
            case 3:
                namaUrl = 'camup'
                break
            case 4:
                namaUrl = 'camupcon'
                break
            case 5:
                namaUrl = 'camzoomplus'
                break
            case 6:
                namaUrl = 'camzoompluscon'
                break
            case 7:
                namaUrl = 'camleft'
                break
            case 8:
                namaUrl = 'camleftcon'
                break
            case 9:
                namaUrl = 'camleftup'
                break
            case 10:
                namaUrl = 'camleftupcon'
                break
            case 11:
                namaUrl = 'camright'
                break
            case 12:
                namaUrl = 'camrightup'
                break
            case 13:
                namaUrl = 'camdown'
                break
            case 14:
                namaUrl = 'camautopan'
                break
            case 15:
                namaUrl = 'camautopanstop'
                break
            case 16:
                namaUrl = 'camstop'
                break
            case 17:
                namaUrl = 'camfocusmin'
                break
            case 18:
                namaUrl = 'camfocusplus'
                break
            case 19:
                namaUrl = 'camfocusstop'
                break
            case 20:
                namaUrl = 'camleftdown'
                break
            case 21:
                namaUrl = 'camrightdown'
                break
            case 22:
                namaUrl = 'camirismin'
                break
            case 23:
                namaUrl = 'camirisplus'
                break
            case 24:
                namaUrl = 'camirisstop'
                break
            case 25:
                namaUrl = 'camwiper'
                break
            case 26:
                namaUrl = 'camstopwiper'
                break
            case 27:
                namaUrl = 'cammenu'
                break
            case 28:
                namaUrl = 'camstopzoom'
                break
            default:
                break
        }

        // alert(namaUrl)
        try {
            const response = await axios.post(API_BASE + namaUrl,
                {
                    headers: {
                        'Authorization': Token
                    }
                }
            );
            if (response.data.success) {
                console.log('ok')
            }
        } catch (error) {
            console.log({ error });
        }
    }

    return (
        <Modal
            open={isOpen}
            onClose={() => setIsOpen(false)}
            aria-labelledby="modal-modal-title"
            aria-describedby="modal-modal-description"
        >
            <Box sx={style}>
                <div className='row d-flex align-items-center h-100'>
                    <div className='col-md-10'>
                        {imgError ? (
                            <div
                                // eslint-disable-next-line react/no-danger
                                dangerouslySetInnerHTML={{
                                    __html: `<iframe 
                                    src="${imgSelect}"
                                     frameborder="0" 
                                     height="600" 
                                     scrolling="yes" 
                                     width="100%">
                                     </iframe>`,
                                }}
                            />
                        ) : (
                            // eslint-disable-next-line jsx-a11y/alt-text
                            <img
                                onError={() => setImgError(true)}
                                style={{
                                    WebkitUserSelect: 'none',
                                    margin: 'auto',
                                    width: 'inherit',
                                    height: '70vh'
                                }}
                                src={imgSelect}
                            />
                        )}

                    </div>
                    <div className='col-md-2'>
                        <div className='row'>
                            <div className='col-md-12 align-self-center'>
                                <div className='row'>
                                    <div className='col-12 col-md-12'>
                                        <div className='row'>
                                            <div className='col-8 col-md-8'>
                                                <div
                                                    className='active mb-2 p-2 br-15  br-15 position-tab-menu menu-tab'
                                                    style={{
                                                        borderRadius: 5,
                                                    }}
                                                >
                                                    <div className='hover-button'
                                                        style={{
                                                            textAlign: 'center'
                                                        }}>
                                                        {wipers ? (
                                                            <FontAwesomeIcon
                                                                icon={faStopCircle}
                                                                size='lg'
                                                                onClick={() => {
                                                                    handleControl(5);
                                                                    handleControl(28);
                                                                    setWipers(false);
                                                                }
                                                                }
                                                            />
                                                        ) : (
                                                            <FontAwesomeIcon
                                                                icon={faHandSparkles}
                                                                size='lg'
                                                                onClick={() => {
                                                                    handleControl(25);
                                                                    setWipers(true)
                                                                }
                                                                }
                                                            />
                                                        )}
                                                    </div>
                                                </div>
                                            </div>
                                            <div className='col-4 col-md-4'>
                                                <div className='pointer-cursor'>
                                                    {continuesMode ? (
                                                        <FontAwesomeIcon
                                                            icon={faToggleOn}
                                                            size='lg'
                                                            onClick={() => {
                                                                setContinuesMode(false)
                                                            }
                                                            }
                                                        />
                                                    ) : (
                                                        <FontAwesomeIcon
                                                            icon={faToggleOff}
                                                            size='lg'
                                                            onClick={() => {
                                                                setContinuesMode(true)
                                                            }}
                                                        />
                                                    )}
                                                </div>
                                            </div>
                                            <div className='col-12 col-md-12'
                                            >
                                                <div className='zoom-toggle mt-2'>
                                                    <div className='w-100 br-15 active pr-3 pl-3 pt-2 pb-2'
                                                        style={{ borderRadius: 5 }}
                                                    >
                                                        {continuesMode ? (
                                                            <div className='row '>
                                                                <div className='col-6 col-md-6 pb-2'
                                                                    style={{ textAlign: 'center' }}
                                                                >
                                                                    <button
                                                                        type='button'
                                                                        className='btn'
                                                                    >
                                                                        <FontAwesomeIcon
                                                                            icon={faPlus}
                                                                            size='lg'
                                                                            color='black'
                                                                            onClick={() => {
                                                                                handleControl(6);
                                                                                handleControl(28);
                                                                            }}
                                                                        />
                                                                    </button>
                                                                </div>
                                                                <div className='col-6 col-md-6 pb-2'
                                                                    style={{ textAlign: 'center' }}
                                                                >
                                                                    <button
                                                                        type='button'
                                                                        className='btn'>
                                                                        <FontAwesomeIcon
                                                                            icon={faMinus}
                                                                            color='black'
                                                                            size='lg'
                                                                            onClick={() => {
                                                                                handleControl(2);
                                                                                handleControl(28);
                                                                            }}
                                                                        />
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        ) : (
                                                            <div className='row '>
                                                                <div className='col-6 col-md-6 pb-2'
                                                                    style={{ textAlign: 'center' }}
                                                                >
                                                                    <button
                                                                        type='button'
                                                                        className='btn '>
                                                                        <FontAwesomeIcon
                                                                            icon={faPlus}
                                                                            color='black'
                                                                            size='lg'
                                                                            onClick={() => {
                                                                                handleControl(5)
                                                                                handleControl(28)
                                                                            }
                                                                            }
                                                                        />
                                                                    </button>
                                                                </div>
                                                                <div className='col-6 col-md-6 pb-2'
                                                                    style={{ textAlign: 'center' }}
                                                                >
                                                                    <button
                                                                        type='button'
                                                                        className='btn '>
                                                                        <FontAwesomeIcon
                                                                            icon={faMinus}
                                                                            size='lg'
                                                                            color='black'
                                                                            onClick={() => {
                                                                                handleControl(1)
                                                                                handleControl(28)
                                                                            }}
                                                                        />
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        )}
                                                    </div>
                                                </div>
                                            </div>

                                            <div className='col-6 col-md-6 '
                                                style={{ textAlign: 'center' }}
                                            >
                                                <div className=' mt-3  '
                                                    style={{}}
                                                >
                                                    <button className='btn btn-success w-100'
                                                        onClick={() => handleControl(27)}
                                                    >
                                                        <FontAwesomeIcon icon={faBars} size='lg'

                                                        />
                                                    </button>
                                                </div>
                                            </div>
                                            <div className='col-6 col-md-6 mb-3'>
                                                <div className=' mt-3'>
                                                    <button className='btn btn-primary w-100'
                                                        onClick={() => handleControl(1)}
                                                    >
                                                        <FontAwesomeIcon icon={faMousePointer} size='lg'

                                                        />
                                                        Point
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div className='col-12 col-md-12'
                                    style={{ width: '50%' }}
                                >
                                    <div className=''
                                        style={{
                                            backgroundColor: 'white',
                                            borderRadius: '50%',
                                            border: 1,
                                            width: 150, height: 150,
                                            textAlign: 'center',
                                            alignContent: 'center',
                                        }}
                                    >
                                        {continuesMode ? (
                                            <div className='row h-100'
                                                style={{ width: '80%', position: 'relative', left: 25 }}
                                            >
                                                <div className='col-4 col-md-4 d-flex justify-content-center align-items-end cust-post'>
                                                    <div className='hover-button'>
                                                        <FontAwesomeIcon
                                                            onClick={() => {
                                                                handleControl(10)
                                                                handleControl(16)
                                                            }}
                                                            icon={faCircle} size='sm'

                                                        />
                                                    </div>
                                                </div>
                                                <div className='col-4 col-md-4 d-flex align-items-center justify-content-center'>
                                                    <div className='hover-button '>
                                                        <FontAwesomeIcon
                                                            onClick={() => handleControl(4)}
                                                            icon={faArrowUp} size='lg' />
                                                    </div>
                                                </div>
                                                <div className='col-4 col-md-4 d-flex align-items-end justify-content-center cust-post-2'>
                                                    <div className='hover-button'>
                                                        <FontAwesomeIcon
                                                            onClick={() => {
                                                                handleControl(12)
                                                                handleControl(16)
                                                            }}
                                                            icon={faCircle} size='sm' />
                                                    </div>
                                                </div>
                                                <div className='col-3 col-md-3 d-flex align-items-center justify-content-center'>
                                                    <div className='hover-button'>
                                                        <FontAwesomeIcon
                                                            onClick={() => handleControl(8)}
                                                            icon={faArrowLeft} size='lg' />
                                                    </div>
                                                </div>
                                                <div className='col-6 col-md-6 d-flex align-items-center justify-content-center border-bor'
                                                >
                                                    {autopans ? (
                                                        <div className='hover-button'
                                                            style={{ border: 1, borderColor: 'black' }}
                                                        >
                                                            <FontAwesomeIcon
                                                                onClick={() => {
                                                                    handleControl(15)
                                                                    setAutopans(false)

                                                                }}
                                                                icon={faBan} size='2x' />
                                                        </div>
                                                    ) : (
                                                        <div className='hover-button'
                                                            style={{ border: 1, borderColor: 'black' }}
                                                        >
                                                            <FontAwesomeIcon
                                                                onClick={() => {
                                                                    handleControl(14)
                                                                    setAutopans(true)
                                                                }}
                                                                icon={faSyncAlt} size='2x' />
                                                        </div>
                                                    )}
                                                </div>
                                                <div className='col-3 col-md-3 d-flex align-items-center justify-content-center'>
                                                    <div className='hover-button'>
                                                        <FontAwesomeIcon
                                                            onClick={() => handleControl(11)}
                                                            icon={faArrowRight} size='lg' />
                                                    </div>
                                                </div>
                                                <div className='col-4 col-md-4 cust-post'>
                                                    <div className='hover-button'>
                                                        <FontAwesomeIcon
                                                            onClick={() => {

                                                                handleControl(20)
                                                                handleControl(16)
                                                            }}
                                                            icon={faCircle} size='lg' />
                                                    </div>
                                                </div>
                                                <div className='col-4 col-md-4 d-flex align-items-center justify-content-center'>
                                                    <div className='hover-button '>
                                                        <FontAwesomeIcon
                                                            onClick={() => handleControl(13)}
                                                            icon={faArrowDown} size='lg' />
                                                    </div>
                                                </div>
                                                <div className='col-4 col-md-4 cust-post-2'>
                                                    <div className='hover-button'>
                                                        <FontAwesomeIcon
                                                            onClick={() => {
                                                                handleControl(21)
                                                                handleControl(16)
                                                            }}
                                                            icon={faCircle} size='lg' />
                                                    </div>
                                                </div>
                                            </div>
                                        ) : (
                                            <div className='row h-100'
                                                style={{ width: '80%', position: 'relative', left: 25 }}
                                            >
                                                <div className='col-4 col-md-4 d-flex justify-content-center align-items-end cust-post'>
                                                    <div className='hover-button'>
                                                        <FontAwesomeIcon
                                                            onClick={() => {
                                                                handleControl(9)
                                                                handleControl(16)
                                                            }}
                                                            icon={faCircle} size='sm' />
                                                    </div>
                                                </div>
                                                <div className='col-4 col-md-4 d-flex align-items-center justify-content-center'>
                                                    <div className='hover-button '>
                                                        <FontAwesomeIcon
                                                            onClick={() => handleControl(3)}
                                                            icon={faArrowUp} size='lg' />

                                                    </div>
                                                </div>
                                                <div className='col-4 col-md-4 d-flex align-items-end justify-content-center cust-post-2'>
                                                    <div className='hover-button'>
                                                        <FontAwesomeIcon
                                                            onClick={() => {
                                                                handleControl(12)
                                                                handleControl(16)
                                                            }}
                                                            icon={faCircle} size='sm' />
                                                    </div>
                                                </div>
                                                <div className='col-3 col-md-3 d-flex align-items-center justify-content-center'>
                                                    <div className='hover-button'>
                                                        <FontAwesomeIcon
                                                            onClick={() => handleControl(7)}
                                                            icon={faArrowLeft} size='lg' />

                                                    </div>
                                                </div>
                                                <div className='col-6 col-md-6 d-flex align-items-center justify-content-center border-bor'>
                                                    {autopans ? (
                                                        <div className='hover-button'>
                                                            <FontAwesomeIcon
                                                                onClick={() => {
                                                                    handleControl(15)
                                                                    setAutopans(false)
                                                                }}
                                                                icon={faBan} size='2x' />
                                                        </div>
                                                    ) : (
                                                        <div className='hover-button'>
                                                            <FontAwesomeIcon
                                                                onClick={() => {
                                                                    handleControl(14)
                                                                    setAutopans(true)
                                                                }}
                                                                icon={faSyncAlt} size='2x' />
                                                        </div>
                                                    )}
                                                </div>
                                                <div className='col-3 col-md-3 d-flex align-items-center justify-content-center'>
                                                    <div className='hover-button'>
                                                        <FontAwesomeIcon
                                                            onClick={() => handleControl(11)}
                                                            icon={faArrowRight} size='lg' />
                                                    </div>
                                                </div>
                                                <div className='col-4 col-md-4 cust-post'>
                                                    <div className='hover-button'>
                                                        <FontAwesomeIcon
                                                            onClick={() => {
                                                                handleControl(20)
                                                                handleControl(16)
                                                            }}
                                                            icon={faCircle} size='sm' />
                                                    </div>
                                                </div>
                                                <div className='col-4 col-md-4 d-flex align-items-center justify-content-center'>
                                                    <div className='hover-button '>
                                                        <FontAwesomeIcon
                                                            onClick={() => handleControl(13)}
                                                            icon={faArrowDown} size='lg' />
                                                    </div>
                                                </div>
                                                <div className='col-4 col-md-4 cust-post-2'>
                                                    <div className='hover-button'>
                                                        <FontAwesomeIcon
                                                            onClick={() => {
                                                                handleControl(21)
                                                                handleControl(16)
                                                            }}
                                                            icon={faCircle} size='sm' />
                                                    </div>
                                                </div>
                                            </div>
                                        )}
                                    </div>
                                </div>
                                <div className=''
                                // style={{ borderRadius: 5, width: 350 }}
                                >
                                    <div className='row mt-3'
                                        style={{ textAlign: 'center' }}
                                    >
                                        <div className='col-md-12 d-flex justify-content-around'>
                                            <div className='hover-button p-3 d-flex flex-column'>
                                                <FontAwesomeIcon
                                                    onClick={() => {
                                                        handleControl(17)
                                                        handleControl(19)
                                                    }}
                                                    icon={faRadiation} size='2x' />
                                                <div className='pt-1 font-weight-bold'>Focus -</div>
                                            </div>

                                            <div className='hover-button p-3 d-flex flex-column'>
                                                <FontAwesomeIcon
                                                    onClick={() => {
                                                        handleControl(22)
                                                        handleControl(24)
                                                    }}
                                                    icon={faCompress} size='2x' />
                                                <div className='pt-1 font-weight-bold'>Iris -</div>
                                            </div>
                                        </div>

                                        <div className='col-md-12 d-flex justify-content-around'
                                        >
                                            <div className='hover-button p-3 d-flex flex-column'
                                            >
                                                <FontAwesomeIcon
                                                    onClick={() => {
                                                        handleControl(18)
                                                        handleControl(19)
                                                    }}
                                                    icon={faRadiationAlt} size='2x' />
                                                <div className='pt-1 font-weight-bold'>Focus +</div>
                                            </div>
                                            <div className='hover-button p-3 d-flex flex-column'>
                                                <FontAwesomeIcon
                                                    onClick={() => {
                                                        handleControl(23)
                                                        handleControl(24)
                                                    }}
                                                    icon={faExpand} size='2x' />
                                                <div className='pt-1 font-weight-bold'>Iris +</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </Box>
        </Modal>
    )
}

export default ModalCam

