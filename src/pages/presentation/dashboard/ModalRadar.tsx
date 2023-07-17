import { Box, Modal } from '@mui/material'
import React, { FC, useEffect, useState } from 'react'
import axios from 'axios';
import PaginationButtons, { PER_COUNT, dataPagination } from '../../../components/PaginationButtons';
import Card, { CardActions, CardBody, CardHeader, CardLabel, CardTitle } from '../../../components/bootstrap/Card';
import Button from '../../../components/bootstrap/Button';

const style = {
    position: 'absolute' as 'absolute',
    top: '50%',
    left: '50%',
    transform: 'translate(-50%, -50%)',
    width: 1000,
    height: 500,
    bgcolor: 'background.paper',
    border: '2px solid #000',
    boxShadow: 24,
    p: 4,
    '&:hover': { backgroundColor: 'white', cursor: 'default' },
    borderRadius: 3,
    padding: 0,
};

interface IModalRadarProps {
    isOpen: boolean;
    setIsOpen: any;
}
const ModalRadar: FC<IModalRadarProps> = ({
    isOpen, setIsOpen
}) => {
    const UrlBase = process.env.REACT_APP_BASE_API_URL;

    const [data, setData] = useState<any[]>([])

    const [currentPage, setCurrentPage] = useState(1);
    const [perPage, setPerPage] = useState(PER_COUNT['10']);

    const fetchData = async () => {
        try {
            const response = await axios.get(`${UrlBase}radardatalist`);
            if (response.data.success) {
                setData(response.data.message);
            }
        } catch (error) {
            console.log({ error });
        }
    };

    useEffect(() => {
        fetchData()
        // eslint-disable-next-line react-hooks/exhaustive-deps
    }, [])
    return (
        <Modal
            open={isOpen}
            onClose={() => setIsOpen(false)}
            aria-labelledby="modal-modal-title"
            aria-describedby="modal-modal-description"
        >
            <Box sx={style}>
                <Card stretch>
                    <CardHeader borderSize={1}>
                        <CardLabel icon='Alarm' iconColor='info'>
                            <CardTitle tag='div' className='h5'>
                                RADAR List
                            </CardTitle>
                        </CardLabel>
                        <CardActions>
                            <Button
                                color='info'
                                icon='CloudDownload'
                                isLight
                                tag='a'
                                to='/somefile.txt'
                                target='_blank'
                                download>
                                Export
                            </Button>
                        </CardActions>
                    </CardHeader>
                    <CardBody
                        // className='table-responsive'
                        style={{ height: 400 }}
                        isScrollable>
                        <table className='table table-modern'>
                            <thead>
                                <tr>
                                    <th>
                                        target_id
                                    </th>
                                    <th>
                                        Name
                                    </th>
                                    <th>altitude</th>
                                    <th>Latitude</th>
                                    <th>Longitude</th>
                                    <th>Speed</th>
                                    <th>Course</th>
                                    <th>Heading</th>
                                    <th>Status</th>
                                    <th>timestamp</th>
                                </tr>
                            </thead>
                            <tbody>
                                {dataPagination(data, currentPage, perPage).map((item) => (
                                    <tr key={item.id}>

                                        <td>
                                            {item.target_id}
                                        </td>
                                        <td>
                                            {item?.sensor_data?.sensor?.name}
                                        </td>
                                        <td>
                                            {item.altitude}

                                        </td>
                                        <td>
                                            {item.latitude}

                                        </td>
                                        <td>
                                            {item.longitude}

                                        </td>
                                        <td>
                                            {item.speed}

                                        </td>
                                        <td>
                                            {item.course}

                                        </td>
                                        <td>
                                            {item.heading}

                                        </td>
                                        <td>
                                            {item?.sensor_data?.sensor?.status}

                                        </td>
                                        <td>
                                            {item.timestamp}

                                        </td>
                                    </tr>
                                ))}
                            </tbody>
                        </table>
                    </CardBody>
                    <PaginationButtons
                        data={data}
                        label='items'
                        setCurrentPage={setCurrentPage}
                        currentPage={currentPage}
                        perPage={perPage}
                        setPerPage={setPerPage}
                    />
                </Card>
            </Box>
        </Modal>
    )
}

export default ModalRadar