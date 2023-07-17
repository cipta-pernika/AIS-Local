// eslint-disable-next-line eslint-comments/disable-enable-pair
/* eslint-disable @typescript-eslint/no-unused-vars */
// eslint-disable-next-line eslint-comments/disable-enable-pair
/* eslint-disable react/button-has-type */
import React, { useState } from 'react';
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
import PageWrapper from '../../../layout/PageWrapper/PageWrapper';
import Page from '../../../layout/Page/Page';

const CAM_URL = 'http://192.168.55.222/ISAPI/Streaming/channels/102/httpPreview?auth=YWRtaW46QW10ZWsxMjM0NQ==%22'
// const CAM_URL = 'https://cctv.jabarprov.go.id/zm/cgi-bin/nph-zms?monitor=28&amp;user=view&amp;pass=view123'

const CameraPage = () => {
    const [wipers, setWipers] = useState(false);
    const [autopans, setAutopans] = useState(false);
    const [continuesMode, setContinuesMode] = useState(false);
    const [imgError, setImgError] = useState(false)
    const [imgSelect, setImgSelect] = useState(CAM_URL)
    return (
        <PageWrapper title='Camera Page'>
            <title>Camera Page</title>
            <Page>
                <div className='row d-flex align-items-center h-100'>
                    <div className='col-md-8'>
                        {imgError ? (
                            <div
                                // eslint-disable-next-line react/no-danger
                                dangerouslySetInnerHTML={{
                                    __html: `<iframe 
                                    src="${imgSelect}"
                                     frameborder="0" 
                                     height="500" 
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
                                    height: '85vh'
                                }}
                                src={imgSelect}
                            />
                        )}

                    </div>
                    <div className='col-md-4'>
                        <div className='row'>
                            <div className='col-md-12 align-self-center'>
                                <div className='row'>
                                    <div className='col-6 col-md-6'>
                                        <div className='row'>
                                            <div className='col-8 col-md-8'>
                                                <div className='active mb-2 p-2 br-15  br-15 position-tab-menu menu-tab'>
                                                    {wipers ? (
                                                        <div className='hover-button'>
                                                            <FontAwesomeIcon
                                                                icon={faStopCircle}
                                                                size='lg'
                                                            />
                                                        </div>
                                                    ) : (
                                                        <div className='hover-button'>
                                                            <FontAwesomeIcon
                                                                icon={faHandSparkles}
                                                                size='lg'
                                                            />
                                                        </div>
                                                    )}
                                                </div>
                                            </div>
                                            <div className='col-4 col-md-4'>
                                                <div className='pointer-cursor '>
                                                    {continuesMode ? (
                                                        <FontAwesomeIcon
                                                            icon={faToggleOn}
                                                            size='lg'
                                                        />
                                                    ) : (
                                                        <FontAwesomeIcon
                                                            icon={faToggleOff}
                                                            size='lg'
                                                        />
                                                    )}
                                                </div>
                                            </div>
                                            <div className='col-12 col-md-12'>
                                                <div className='zoom-toggle mt-2'>
                                                    <div className='w-100 br-15 active pr-3 pl-3 pt-2 pb-2'>
                                                        {continuesMode ? (
                                                            <div className='row '>
                                                                <div className='col-6 col-md-6 pb-2'>
                                                                    <button
                                                                        type='button'
                                                                        className='btn '>
                                                                        <FontAwesomeIcon
                                                                            icon={faPlus}
                                                                            size='lg'
                                                                        />
                                                                    </button>
                                                                </div>
                                                                <div className='col-6 col-md-6 pb-2'>
                                                                    <button
                                                                        type='button'
                                                                        className='btn '>
                                                                        <FontAwesomeIcon
                                                                            icon={faMinus}
                                                                            size='lg'
                                                                        />
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        ) : (
                                                            <div className='row '>
                                                                <div className='col-6 col-md-6 pb-2'>
                                                                    <button
                                                                        type='button'
                                                                        className='btn '>
                                                                        <FontAwesomeIcon
                                                                            icon={faPlus}
                                                                            size='lg'
                                                                        />
                                                                    </button>
                                                                </div>
                                                                <div className='col-6 col-md-6 pb-2'>
                                                                    <button
                                                                        type='button'
                                                                        className='btn '>
                                                                        <FontAwesomeIcon
                                                                            icon={faMinus}
                                                                            size='lg'
                                                                        />
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        )}
                                                    </div>
                                                </div>
                                            </div>

                                            <div className='col-4 col-md-4 '>
                                                <div className='menu mt-3 br-15 menu-camera '>
                                                    <div className='hover-button '>
                                                        <FontAwesomeIcon icon={faBars} size='lg' />
                                                    </div>
                                                </div>
                                            </div>
                                            <div className='col-8 col-md-8 mb-2'>
                                                <div className='point-to mt-3'>
                                                    <button className='btn btn-primary w-100'>
                                                        <FontAwesomeIcon icon={faMousePointer} size='lg' />

                                                        Point
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div className='col-6 col-md-6'>
                                        <div className='round-controller'>
                                            {continuesMode ? (
                                                <div className='row h-100'>
                                                    <div className='col-4 col-md-4 d-flex justify-content-center align-items-end cust-post'>
                                                        <div className='hover-button'>
                                                            <FontAwesomeIcon icon={faCircle} size='sm' />
                                                        </div>
                                                    </div>
                                                    <div className='col-4 col-md-4 d-flex align-items-center justify-content-center'>
                                                        <div className='hover-button '>
                                                            <FontAwesomeIcon icon={faArrowUp} size='lg' />
                                                        </div>
                                                    </div>
                                                    <div className='col-4 col-md-4 d-flex align-items-end justify-content-center cust-post-2'>
                                                        <div className='hover-button'>
                                                            <FontAwesomeIcon icon={faCircle} size='sm' />
                                                        </div>
                                                    </div>
                                                    <div className='col-3 col-md-3 d-flex align-items-center justify-content-center'>
                                                        <div className='hover-button'>
                                                            <FontAwesomeIcon icon={faArrowLeft} size='lg' />
                                                        </div>
                                                    </div>
                                                    <div className='col-6 col-md-6 d-flex align-items-center justify-content-center border-bor'>
                                                        {autopans ? (
                                                            <div className='hover-button'>
                                                                <FontAwesomeIcon icon={faBan} size='2x' />
                                                            </div>
                                                        ) : (
                                                            <div className='hover-button'>
                                                                <FontAwesomeIcon icon={faSyncAlt} size='2x' />
                                                            </div>
                                                        )}
                                                    </div>
                                                    <div className='col-3 col-md-3 d-flex align-items-center justify-content-center'>
                                                        <div className='hover-button'>
                                                            <FontAwesomeIcon icon={faArrowRight} size='lg' />
                                                        </div>
                                                    </div>
                                                    <div className='col-4 col-md-4 cust-post'>
                                                        <div className='hover-button'>
                                                            <FontAwesomeIcon icon={faCircle} size='lg' />
                                                        </div>
                                                    </div>
                                                    <div className='col-4 col-md-4 d-flex align-items-center justify-content-center'>
                                                        <div className='hover-button '>
                                                            <FontAwesomeIcon icon={faArrowDown} size='lg' />
                                                        </div>
                                                    </div>
                                                    <div className='col-4 col-md-4 cust-post-2'>
                                                        <div className='hover-button'>
                                                            <FontAwesomeIcon icon={faCircle} size='lg' />
                                                        </div>
                                                    </div>
                                                </div>
                                            ) : (
                                                <div className='row h-100'>
                                                    <div className='col-4 col-md-4 d-flex justify-content-center align-items-end cust-post'>
                                                        <div className='hover-button'>
                                                            <FontAwesomeIcon icon={faCircle} size='sm' />
                                                        </div>
                                                    </div>
                                                    <div className='col-4 col-md-4 d-flex align-items-center justify-content-center'>
                                                        <div className='hover-button '>
                                                            <FontAwesomeIcon icon={faArrowUp} size='lg' />

                                                        </div>
                                                    </div>
                                                    <div className='col-4 col-md-4 d-flex align-items-end justify-content-center cust-post-2'>
                                                        <div className='hover-button'>
                                                            <FontAwesomeIcon icon={faCircle} size='sm' />
                                                        </div>
                                                    </div>
                                                    <div className='col-3 col-md-3 d-flex align-items-center justify-content-center'>
                                                        <div className='hover-button'>
                                                            <FontAwesomeIcon icon={faArrowLeft} size='lg' />

                                                        </div>
                                                    </div>
                                                    <div className='col-6 col-md-6 d-flex align-items-center justify-content-center border-bor'>
                                                        {autopans ? (
                                                            <div className='hover-button'>
                                                                <FontAwesomeIcon icon={faBan} size='2x' />
                                                            </div>
                                                        ) : (
                                                            <div className='hover-button'>
                                                                <FontAwesomeIcon icon={faSyncAlt} size='2x' />
                                                            </div>
                                                        )}
                                                    </div>
                                                    <div className='col-3 col-md-3 d-flex align-items-center justify-content-center'>
                                                        <div className='hover-button'>
                                                            <FontAwesomeIcon icon={faArrowRight} size='lg' />
                                                        </div>
                                                    </div>
                                                    <div className='col-4 col-md-4 cust-post'>
                                                        <div className='hover-button'>
                                                            <FontAwesomeIcon icon={faCircle} size='sm' />
                                                        </div>
                                                    </div>
                                                    <div className='col-4 col-md-4 d-flex align-items-center justify-content-center'>
                                                        <div className='hover-button '>
                                                            <FontAwesomeIcon icon={faArrowDown} size='lg' />
                                                        </div>
                                                    </div>
                                                    <div className='col-4 col-md-4 cust-post-2'>
                                                        <div className='hover-button'>
                                                            <FontAwesomeIcon icon={faCircle} size='sm' />
                                                        </div>
                                                    </div>
                                                </div>
                                            )}
                                        </div>
                                    </div>
                                </div>
                                <div className='active br-15'>
                                    <div className='row mt-3'>
                                        <div className='col-md-12 d-flex justify-content-around'>
                                            <div className='hover-button p-3 d-flex flex-column'>
                                                <FontAwesomeIcon icon={faRadiation} size='2x' />
                                                <div className='pt-1 font-weight-bold'>Focus -</div>
                                            </div>

                                            <div className='hover-button p-3 d-flex flex-column'>
                                                <FontAwesomeIcon icon={faCompress} size='2x' />
                                                <div className='pt-1 font-weight-bold'>Iris -</div>
                                            </div>
                                        </div>

                                        <div className='col-md-12 d-flex justify-content-around'>
                                            <div className='hover-button p-3 d-flex flex-column'>
                                                <FontAwesomeIcon icon={faRadiationAlt} size='2x' />
                                                <div className='pt-1 font-weight-bold'>Focus +</div>
                                            </div>
                                            <div className='hover-button p-3 d-flex flex-column'>
                                                <FontAwesomeIcon icon={faExpand} size='2x' />
                                                <div className='pt-1 font-weight-bold'>Iris +</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </Page>
        </PageWrapper>
    );
};

export default CameraPage;
