import { useFormik } from 'formik';
import React, { FC } from 'react'
import axios from 'axios';
import PropTypes from 'prop-types';
import { toast } from 'react-toastify';
import showNotification from '../../../components/extras/showNotification';
import Icon from '../../../components/icon/Icon';
import Modal, {
    ModalBody,
    ModalFooter,
    ModalHeader,
    ModalTitle,
} from '../../../components/bootstrap/Modal';
import FormGroup from '../../../components/bootstrap/forms/FormGroup';
import Input from '../../../components/bootstrap/forms/Input';
import Button from '../../../components/bootstrap/Button';
import Label from '../../../components/bootstrap/forms/Label';
import Checks, { ChecksGroup } from '../../../components/bootstrap/forms/Checks';

interface ISensorModalProps {
    id: number;
    isOpen: boolean;
    setIsOpen(...args: unknown[]): unknown;
    data: any;
    isEdit: boolean;
    getData: any;
}

const CreateEditSensor: FC<ISensorModalProps> = ({
    id, isOpen, setIsOpen, data, isEdit, getData, }) => {
    const Token = `Bearer ${localStorage.getItem('token')}`
    const UrlBase = `${process.env.REACT_APP_BASE_API_URL}sensors/`;

    const formik = useFormik({
        initialValues: {
            name: data?.name || '',
            datalogger_id: data?.datalogger_id || 1,
            status: data?.status || 'Active',
            interval: data?.interval || 5,
            jarak: data?.jarak || 20,
            jumlah_data: data?.jumlah_data || 200,
        },
        enableReinitialize: true,
        // eslint-disable-next-line @typescript-eslint/no-unused-vars
        onSubmit: async (values) => {
            let pesan = ''
            if (values.name === '') {
                toast.error('please input sensor name!')
            } else {
                if (id === 0) {
                    try {
                        const response = await axios.post(UrlBase,
                            values,
                            {
                                headers: {
                                    'Authorization': Token
                                }
                            }
                        );
                        if (response.status === 201) {
                            pesan = 'Berhasil tambah data sensor'
                            setIsOpen(false);
                            getData()
                        }
                    } catch (error) {
                        pesan = 'Gagal tambah data sensor'
                        console.log({ error });
                    }
                } else {
                    try {
                        const response = await axios.put(UrlBase + id,
                            values,
                            {
                                headers: {
                                    'Authorization': Token
                                }
                            }
                        );
                        if (response.status === 200) {
                            pesan = 'Berhasil update data sensor'
                            setIsOpen(false);
                            getData()
                        }
                    } catch (error) {
                        pesan = 'Gagal update data sensor'
                        console.log({ error });
                    }
                }
                showNotification(
                    <span className='d-flex align-items-center'>
                        <Icon icon='Info' size='lg' className='me-1' />
                        <span>Updated Successfully</span>
                    </span>,
                    pesan,
                );
            }

        },
    });

    if (id || id === 0) {
        return (
            <Modal isOpen={isOpen} setIsOpen={setIsOpen} size='sm' titleId={id.toString()}>
                <ModalHeader setIsOpen={setIsOpen} className='p-4'>
                    <ModalTitle id={id.toString()}>{data?.name || 'New Sensor'}</ModalTitle>
                </ModalHeader>
                <ModalBody className='px-4'>
                    <div className='row g-4'>
                        <FormGroup id='name' label='Name' className='col-md-12'>
                            <Input onChange={formik.handleChange}
                                value={formik.values.name}
                                disabled={!isEdit}
                            />
                        </FormGroup>
                        <FormGroup id='datalogger_id'
                            label='datalogger_id'
                            className='col-md-6'
                        >
                            <Input
                                onChange={formik.handleChange}
                                value={formik.values.datalogger_id}
                                type='number'
                                disabled={!isEdit}
                            />
                        </FormGroup>
                        <FormGroup id='interval' label='interval'
                            className='col-md-6'>
                            <Input
                                onChange={formik.handleChange}
                                value={formik.values.interval}
                                type='number'
                                disabled={!isEdit}
                            />
                        </FormGroup>
                        <FormGroup id='jarak' label='jarak' className='col-md-6'>
                            <Input
                                onChange={formik.handleChange}
                                value={formik.values.jarak}
                                type='number'
                                disabled={!isEdit}
                            />
                        </FormGroup>
                        <FormGroup id='jumlah_data' label='jumlah_data'
                            className='col-md-6'>
                            <Input
                                onChange={formik.handleChange}
                                value={formik.values.jumlah_data}
                                type='number'
                                disabled={!isEdit}
                            />
                        </FormGroup>
                        <FormGroup className='col-md-12'>
                            <Label htmlFor='status'>Status</Label>
                            <ChecksGroup isInline>
                                <Checks
                                    type='radio'
                                    key={0}
                                    id='aktip'
                                    label='Active'
                                    name='status'
                                    value='Active'
                                    onChange={formik.handleChange}
                                    checked={formik.values.status}
                                    disabled={!isEdit}
                                />
                                <Checks
                                    type='radio'
                                    key={1}
                                    id='nonaktip'
                                    label='Non Active'
                                    name='status'
                                    value='Non Active'
                                    onChange={formik.handleChange}
                                    checked={formik.values.status}
                                    disabled={!isEdit}
                                />
                            </ChecksGroup>
                        </FormGroup>
                    </div>
                </ModalBody>
                <ModalFooter className='px-4 pb-4'>
                    <Button
                        color='success'
                        onClick={formik.handleSubmit}
                        hidden={!isEdit}
                    >
                        Save
                    </Button>
                </ModalFooter>
            </Modal>
        );
    }
    return null;
};
CreateEditSensor.propTypes = {
    id: PropTypes.number.isRequired,
    isOpen: PropTypes.bool.isRequired,
    setIsOpen: PropTypes.func.isRequired,
};


export default CreateEditSensor