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


interface ISensorModalProps {
    id: number;
    isOpen: boolean;
    setIsOpen(...args: unknown[]): unknown;
    data: any;
    isEdit: boolean;
    getData: any;
}
const CreateEditUser: FC<ISensorModalProps> = ({
    id, isOpen, setIsOpen, data, isEdit, getData }) => {
    const Token = `Bearer ${localStorage.getItem('token')}`
    const UrlBase = `${process.env.REACT_APP_BASE_API_URL}/users/`

    const formik = useFormik({
        initialValues: {
            name: data?.name || '',
            email: data?.email || '',
            password: data?.password || '',
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
                            pesan = 'Berhasil tambah data user'
                            setIsOpen(false);
                            getData()
                        }
                    } catch (error) {
                        pesan = 'Gagal tambah data user'
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
                            pesan = 'Berhasil update data user'
                            setIsOpen(false);
                            getData()
                        }
                    } catch (error) {
                        pesan = 'Gagal update data user'
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
                    <ModalTitle id={id.toString()}>{data?.name || 'New User'}</ModalTitle>
                </ModalHeader>
                <ModalBody className='px-4'>
                    <div className='row g-4'>
                        <FormGroup id='name' label='Name' className='col-md-12'>
                            <Input onChange={formik.handleChange}
                                value={formik.values.name}
                                disabled={!isEdit}
                            />
                        </FormGroup>
                        <FormGroup id='email'
                            label='email'
                            className='col-md-12'
                        >
                            <Input
                                onChange={formik.handleChange}
                                value={formik.values.email}
                                disabled={!isEdit}
                            />
                        </FormGroup>
                        <FormGroup id='password' label='password'
                            className='col-md-12'>
                            <Input
                                onChange={formik.handleChange}
                                value={formik.values.password}
                                type='password'
                                disabled={!isEdit}
                            />
                        </FormGroup>

                    </div>
                </ModalBody>
                <ModalFooter className='px-4 pb-4'>
                    <Button
                        color='info'
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
CreateEditUser.propTypes = {
    id: PropTypes.number.isRequired,
    isOpen: PropTypes.bool.isRequired,
    setIsOpen: PropTypes.func.isRequired,
};

export default CreateEditUser