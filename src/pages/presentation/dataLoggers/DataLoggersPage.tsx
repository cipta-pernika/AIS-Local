import React, { useState, useMemo, useEffect } from 'react'
import axios from 'axios'
import { Grid } from '@mui/material'
import { ToastContainer, toast } from 'react-toastify'
import LoadingSpinner from '../../../components/LoadingSpinner'
import NewTable from '../../../components/NewTable'
import PageWrapper from '../../../layout/PageWrapper/PageWrapper'
import Page from '../../../layout/Page/Page'

const DataLoggersPage = () => {
    const [isLoading, setISLoading] = useState(false)
    const [data, setData] = useState<any[]>([])
    const [dataSelect, setDataSelect] = useState<any>({})
    const title = 'Data Loggers'
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
        <PageWrapper>
            <ToastContainer />
            <title>Data Loggers</title>
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
                                            tambah={0}
                                            edit={0}
                                            hapus={0}
                                            ekspor={ekspor}
                                        />
                                        {/* <TableFrontHandle columns={columns} data={data} setDataSelect={setDataSelect} /> */}
                                    </>
                            }
                        </Grid>
                    </div>
                </div>
            </Page>
        </PageWrapper>
    )
}

export default DataLoggersPage