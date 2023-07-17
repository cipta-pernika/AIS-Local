import React, { useState, useMemo, useEffect } from 'react'
import axios from 'axios'
import { Grid } from '@mui/material'
import { ToastContainer, toast } from 'react-toastify'
import LoadingSpinner from '../../../components/LoadingSpinner'
import NewTable from '../../../components/NewTable'
import ActionButton from '../../../components/ActionButton'
import CreateEditSensor from './CreateEditSensor'
import PageWrapper from '../../../layout/PageWrapper/PageWrapper'
import Page from '../../../layout/Page/Page'

const SensorsPage = () => {
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
    const UrlBase = `${process.env.REACT_APP_BASE_API_URL}/sensors/`

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
        setIsEdit(true)
        setEditModalStatus(true)
    }

    const edit = (id: any) => {
        setIsEdit(true)
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
                    const response = await axios.delete(`https://siege.cakrawala.id/api/sensors/${datax.selectedRows[i].id}`,
                        {
                            headers: {
                                'Authorization': 'Bearer 2|mM0oGS1MFdwNnE2yEi6iaReR6AICDbSN1bFE4zcg'
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
        <PageWrapper>
            <ToastContainer />
            <title>Sensors</title>
            <Page>
                <div className='row d-flex align-items-center'>
                    <div className="col-md-12">
                        <Grid item xs={12}>
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
                        </Grid>
                    </div>
                </div>
            </Page>
            <CreateEditSensor
                setIsOpen={setEditModalStatus}
                isOpen={editModalStatus}
                id={idSensor}
                data={data1}
                isEdit={isEdit}
                getData={getData}
            />
        </PageWrapper>
    )
}

export default SensorsPage