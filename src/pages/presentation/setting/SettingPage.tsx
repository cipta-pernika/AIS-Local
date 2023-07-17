import React, { FC, useEffect, useState } from 'react'

import axios from 'axios';
import { FormControl, FormControlLabel, FormLabel, Radio, RadioGroup } from '@mui/material';
import { toast } from 'react-toastify';
import FormGroup from '../../../components/bootstrap/forms/FormGroup';
import Input from '../../../components/bootstrap/forms/Input';
import Select from '../../../components/bootstrap/forms/Select';
import Button from '../../../components/bootstrap/Button';

interface ISetProps {
    handleClickSetting: any;
}
const SettingPage: FC<ISetProps> = ({ handleClickSetting }) => {

    const [sensorId, setSensorId] = useState('');
    const [status, setStatus] = useState('');
    const [interval, setInterval] = useState('5');
    const [jarak, setJarak] = useState('');
    const [jumlahData, setJumlahData] = useState('');
    const [logger, setLogger] = useState('')
    const UrlBase = process.env.REACT_APP_BASE_API_URL;
    const [dataSensor, setDataSensor] = useState<any[]>([])
    const Token = `Bearer ${localStorage.getItem('token')}`

    useEffect(() => {
        getLoggers()
        getSensors()
        // eslint-disable-next-line react-hooks/exhaustive-deps
    }, [])

    const getLoggers = async () => {
        // console.log('get logger')
        try {
            const response = await axios.get(`${UrlBase}dataloggers`, {
                headers: {
                    'Authorization': Token
                }
            });
            if (response.status === 200) {
                setLogger(response.data[0].name);
            }
        } catch (error) {
            console.log({ error });
        }

    }
    const getSensors = async () => {
        // console.log('get sensor')
        try {
            const response = await axios.get(`${UrlBase}sensors`, {
                headers: {
                    'Authorization': Token
                }
            });
            if (response.status === 200) {
                setDataSensor(response.data);
                // console.log("Sensor", response.data)
            }
        } catch (error) {
            console.log({ error });
        }
    }

    const handleFormSubmit = async (e: any) => {
        e.preventDefault();
        // Process the form data here
        if (sensorId === '' || interval === '' || jarak === '' || jumlahData === '') {
            toast.error('please check input data!!!')
        } else {
            try {
                const response = await axios.put(`${UrlBase}sensors/${sensorId}`, {
                    "status": status,
                    "interval": interval,
                    "jarak": jarak,
                    "jumlah_data": jumlahData
                }, {
                    headers: {
                        'Authorization': Token
                    }
                });
                if (response.status === 200) {
                    toast.success('Success update data')
                    getSensors()
                    setStatus('Active')
                    // eslint-disable-next-line no-implied-eval
                    setInterval('')
                    setJarak('')
                    setJumlahData('')
                    setSensorId('')
                    handleClickSetting()
                }
            } catch (error) {
                console.log(error)
                toast.error('Failed update data')
            }
        }
    };


    const handleSensor = (e: string) => {
        if (e === '') {
            setStatus('Active')
            // eslint-disable-next-line no-implied-eval
            setInterval('')
            setJarak('')
            setJumlahData('')
            setSensorId('')
        } else {
            const id = parseInt(e, 10)
            const data = dataSensor.find((dt: any) => dt.id === id)
            setSensorId(e)
            // console.log(data)
            if (data) {
                setStatus(data.status)
                setInterval(data.interval)
                setJarak(data.jarak)
                setJumlahData(data.jumlah_data)
            }

        }
    }

    return (
        // <PageWrapper>
        //     <title>Setting</title>
        //     <Page>
        <div className='row d-flex align-items-center'>
            <div className="col-md-12">
                <form onSubmit={handleFormSubmit}>
                    <FormGroup id='dataLogger' label='Data Logger'>
                        <Input
                            type="text"
                            disabled
                            value={logger}
                        />

                    </FormGroup>

                    <FormGroup id="sensor" label="Sensor">
                        <Select
                            value={sensorId}
                            onChange={(e: any) => handleSensor(e.target.value)}
                            ariaLabel='Sensor'
                        >
                            <option value="">Select Sensor</option>
                            {dataSensor.map((item: any) => (
                                <option value={item.id}>{item.name}</option>
                            ))
                            }
                        </Select>
                    </FormGroup>
                    <FormControl>
                        <FormLabel id="demo-radio-buttons-group-label">Status</FormLabel>
                        <RadioGroup
                            aria-labelledby="demo-radio-buttons-group-label"
                            defaultValue="Active"
                            name="radio-buttons-group"
                            value={status}
                            onChange={(e) => setStatus(e.target.value)}
                        >
                            <FormControlLabel value="Active" control={<Radio />} label="Active" />
                            <FormControlLabel value="Inactive" control={<Radio />} label="Inactive" />
                        </RadioGroup>
                    </FormControl>


                    <FormGroup id="interval" label="Interval">
                        <Select
                            ariaLabel='Interval'
                            value={interval}
                            onChange={(e: any) => setInterval(e.target.value)}
                        >
                            <option value=''>Select Interval</option>
                            <option value={1}>1 Minute</option>
                            <option value={5}>5 Minute</option>
                            <option value={10}>10 Minute</option>
                            <option value={30}>30 Minute</option>
                            <option value={60}>60 Minute</option>
                            <option value={120}>120 Minute</option>
                        </Select>
                    </FormGroup>

                    <FormGroup id="jarak" label="Jarak">
                        <Select
                            ariaLabel='Jarak'
                            value={jarak}
                            onChange={(e: any) => setJarak(e.target.value)}
                        >
                            <option value="">Select Jarak</option>
                            <option value={0}>No Limit</option>
                            <option value={1}>1 NM</option>
                            <option value={5}>5 NM</option>
                            <option value={10}>10 NM</option>
                            <option value={20}>20 NM</option>
                            <option value={50}>50 NM</option>
                        </Select>
                    </FormGroup>

                    <FormGroup id="jumlahData" label="Jumlah Data">
                        <Select
                            ariaLabel='Jumlah Data'
                            value={jumlahData}
                            onChange={(e: any) => setJumlahData(e.target.value)}
                        >
                            <option value="">Select Jumlah Data</option>
                            <option value={0}>No Limit</option>
                            <option value={10}>10</option>
                            <option value={25}>25</option>
                            <option value={50}>50</option>
                            <option value={100}>100</option>
                            <option value={200}>200</option>
                        </Select>
                    </FormGroup>
                    <br />
                    <Button type="submit" className='btn btn-primary'>
                        Submit
                    </Button>
                </form>
            </div>
        </div>
        //     </Page>
        // </PageWrapper>
    )
}

export default SettingPage