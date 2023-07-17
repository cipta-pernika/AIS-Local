import React, { FC, useEffect, useMemo, useState } from 'react'
import axios from 'axios';
import { toast } from 'react-toastify';
import { Box, Modal } from '@mui/material';
import ActionButton from '../../../components/ActionButton';
import LoadingSpinner from '../../../components/LoadingSpinner';
import NewTable from '../../../components/NewTable';
import CreateEditSensor from '../sensors/CreateEditSensor';

const style = {
    position: 'fixed' as 'fixes',
    top: '50%',
    left: '50%',
    transform: 'translate(-50%, -50%)',
    width: '80%',
    bgcolor: 'background.paper',
    border: '2px solid #000',
    boxShadow: 24,
    p: 4,
    '&:hover': { backgroundColor: 'white', cursor: 'default' },
    borderRadius: 3,
    padding: 0,
};
interface ISensorProps {
    isOpen: boolean;
    setIsOpen(...args: unknown[]): unknown;
}

const ModalSensors: FC<ISensorProps> = ({
    isOpen, setIsOpen
}) => {
    const [isLoading, setIsLoading] = useState(false)
    const [data, setData] = useState<any[]>([])
    const [dataSelect, setDataSelect] = useState<any>({})
    const title = 'Sensors'
    const icon = 'EdgesensorHigh'
    const isCrud = true
    const [editModalStatus, setEditModalStatus] = useState<boolean>(false);
    const [idSensor, setIdSensor] = useState(0)
    const [data1, setData1] = useState<any>({})
    const [isEdit, setIsEdit] = useState(true)
    const Token = `Bearer ${localStorage.getItem('token')}`
    const UrlBase = `${process.env.REACT_APP_BASE_API_URL}sensors/`;

    const columns = useMemo(
        () => [
            {
                Header: 'Sensors Data',
                columns: [
                    {
                        Header: "Action",
                        // eslint-disable-next-line react/no-unstable-nested-components
                        Cell: ({ cell }: { cell: any }) =>
                        (
                            <ActionButton
                                edit={edit}
                                hapus={hapus}
                                info={info}
                                id={cell.row.values.id}
                            />
                        )
                    },
                    {
                        Header: "id",
                        accessor: "id",
                        isVisible: false
                    },
                    {
                        Header: "datalogger_id",
                        accessor: "datalogger_id",
                    },
                    {
                        Header: "name",
                        accessor: "name",
                    },
                    {
                        Header: "status",
                        accessor: "status",
                    },
                    {
                        Header: "interval",
                        accessor: "interval",
                    },
                    {
                        Header: "jarak",
                        accessor: "jarak",
                    },
                    {
                        Header: "jumlah_data",
                        accessor: "jumlah_data",
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
        // eslint-disable-next-line react-hooks/exhaustive-deps
        []
    );

    useEffect(() => {
        getData();
        // eslint-disable-next-line react-hooks/exhaustive-deps
    }, []);

    const getData = async () => {
        setIsLoading(true)
        try {
            const response = await axios.get(UrlBase, {
                headers: {
                    'Authorization': Token
                }
            });
            if (response.status === 200) {
                setData(response.data)
                setIsLoading(false)
            }
        } catch (error) {
            console.log({ error });
            setIsLoading(false)
        }
    }

    const getData1 = async (id: number) => {
        try {
            const response = await axios.get(UrlBase + id, {
                headers: {
                    'Authorization': Token
                }
            });
            if (response.status === 200) {
                setData1(response.data)
            }
        } catch (error) {
            console.log({ error });
        }

    }

    const tambah = () => {
        // toast.success('Add New')
        setIdSensor(0)
        setData1({})
        setIsOpen(false)
        setIsEdit(true)
        setEditModalStatus(true)
    }

    const edit = (id: any) => {
        setIsEdit(true)
        setIsOpen(false)
        getData1(id)
        setIdSensor(id)
        setEditModalStatus(true)
    }

    const hapus = async (id: any) => {
        try {
            const response = await axios.delete(UrlBase + id,

                {
                    headers: {
                        'Authorization': Token
                    }
                }
            );
            if (response.status === 200) {
                toast.info(response.data.message)
                getData()
            }
        } catch (error) {
            toast.error('Gagal hapus data sensor')
            console.log({ error });
        }
    }

    const hapusSelect = async () => {
        const datax = JSON.parse(dataSelect)
        let jml = 0;
        if (datax.selectedRows.length > 0) {
            for (let i = 0; i < datax.selectedRows.length; i++) {
                try {
                    // eslint-disable-next-line no-await-in-loop
                    const response = await axios.delete(`${UrlBase}${datax.selectedRows[i].id}`,
                        {
                            headers: {
                                'Authorization': Token
                            }
                        }
                    );
                    if (response.status === 200) {
                        jml++
                    }
                } catch (error) {
                    console.log({ error });
                }
            }
            toast.error(`Berhasil hapus ${jml} data!!!`)
            getData()
        } else {
            toast.error('please select data!!!')
        }
    }

    const info = (id: any) => {
        // toast.info('Info id ' + id)
        getData1(id)
        setIdSensor(id)
        setIsEdit(false)
        setEditModalStatus(true)
    }

    const ekspor = (ids: any) => {

        toast.error('Export')
    }

    return (
        <div>
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
                            <>
                                <NewTable
                                    columns={columns}
                                    data={data}
                                    setDataSelect={setDataSelect}
                                    title={title}
                                    icon={icon}
                                    isCrud={isCrud}
                                    tambah={tambah}
                                    edit={edit}
                                    hapus={hapusSelect}
                                    ekspor={ekspor}
                                />
                                {/* <TableFrontHandle columns={columns} data={data} setDataSelect={setDataSelect} /> */}
                            </>
                    }
                </Box>
            </Modal>

            <CreateEditSensor
                setIsOpen={setEditModalStatus}
                isOpen={editModalStatus}
                id={idSensor}
                data={data1}
                isEdit={isEdit}
                getData={getData}
            />
        </div>
    )
}

export default ModalSensors