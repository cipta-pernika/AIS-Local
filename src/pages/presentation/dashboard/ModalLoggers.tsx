import React, { FC, useEffect, useMemo, useState } from 'react'
import axios from 'axios';
import { Box, Modal } from '@mui/material';
import { toast } from 'react-toastify';
// import Modal, {
//     ModalBody,
//     // ModalFooter,
//     ModalHeader,
//     ModalTitle,
// } from '../../../components/bootstrap/Modal';
import LoadingSpinner from '../../../components/LoadingSpinner';
import NewTable from '../../../components/NewTable';

const style = {
    position: 'absolute' as 'absolute',
    top: '50%',
    left: '50%',
    transform: 'translate(-50%, -50%)',
    width: 800,
    bgcolor: 'background.paper',
    border: '2px solid #000',
    boxShadow: 24,
    p: 4,
    '&:hover': { backgroundColor: 'white', cursor: 'default' },
    borderRadius: 3,
    padding: 0,
};
interface ILoggersProps {
    isOpen: boolean;
    setIsOpen(...args: unknown[]): unknown;
}

const ModalLoggers: FC<ILoggersProps> = ({
    isOpen, setIsOpen
}) => {
    const [isLoading, setISLoading] = useState(false)
    const [data, setData] = useState<any[]>([])
    const [dataSelect, setDataSelect] = useState<any>({})
    const title = 'Loggers'
    const icon = 'DataExploration'
    const isCrud = false

    const columns = useMemo(
        () => [
            {
                Header: 'Data Loggers',
                columns: [
                    {
                        Header: "id",
                        accessor: "id",
                    },
                    {
                        Header: "Name",
                        accessor: "name",
                    },
                    {
                        Header: "Serial Number",
                        accessor: "serial_number",
                    },
                    {
                        Header: "latitude",
                        accessor: "latitude",
                    },
                    {
                        Header: "longitude",
                        accessor: "longitude",
                    },
                    {
                        Header: "status",
                        accessor: "status",
                    },
                    {
                        Header: "installation_date",
                        accessor: "installation_date",
                    },
                    {
                        Header: "last_online",
                        accessor: "last_online",
                    },
                    {
                        Header: "created_at",
                        accessor: "created_at",
                    },
                    {
                        Header: "updated_at",
                        accessor: "updated_at",
                    },
                ],
            },
        ],
        []
    );

    useEffect(() => {
        getData();
        // eslint-disable-next-line react-hooks/exhaustive-deps
    }, []);

    const getData = async () => {
        console.log(dataSelect)
        setISLoading(true)
        try {
            const response = await axios.get('https://siege.cakrawala.id/api/dataloggers', {
                headers: {
                    'Authorization': 'Bearer 2|mM0oGS1MFdwNnE2yEi6iaReR6AICDbSN1bFE4zcg'
                }
            });
            if (response.status === 200) {
                setData(response.data)
                setISLoading(false)
            }
        } catch (error) {
            console.log({ error });
            setISLoading(false)
        }
    }

    const ekspor = (ids: any) => {
        toast.error('Export')
    }

    return (
        <Modal
            open={isOpen}
            onClose={() => setIsOpen(false)}
            aria-labelledby="modal-modal-title"
            aria-describedby="modal-modal-description"
        >
            <Box sx={style}>
                {
                    isLoading ?
                        <LoadingSpinner />
                        :
                        <NewTable
                            columns={columns}
                            data={data}
                            setDataSelect={setDataSelect}
                            title={title}
                            icon={icon}
                            isCrud={isCrud}
                            tambah={0}
                            edit={0}
                            hapus={0}
                            ekspor={ekspor}
                        />
                }
            </Box>
        </Modal>
    )
}

export default ModalLoggers