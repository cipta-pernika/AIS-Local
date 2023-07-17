import React, {
	FC, useCallback, useContext
	// , useState 
} from 'react';
import {
	// Link, 
	useNavigate
} from 'react-router-dom';
// import PropTypes from 'prop-types';
import classNames from 'classnames';
import { useFormik } from 'formik';
import axios from 'axios';
import PageWrapper from '../../../layout/PageWrapper/PageWrapper';
import Page from '../../../layout/Page/Page';
import Card, { CardBody } from '../../../components/bootstrap/Card';
import FormGroup from '../../../components/bootstrap/forms/FormGroup';
import Input from '../../../components/bootstrap/forms/Input';
import Button from '../../../components/bootstrap/Button';
import AuthContext from '../../../contexts/authContext';
import logo from '../../../assets/img/logo3.png'

interface ILoginHeaderProps {
	isNewUser?: boolean;
}
const LoginHeader: FC<ILoginHeaderProps> = ({ isNewUser }) => {

	return (
		<>
			<div className='text-center h1 fw-bold mt-5'>Welcome,</div>
			<div className='text-center h4 text-muted mb-5'>Sign in to continue!</div>
		</>
	);
};

LoginHeader.defaultProps = {
	isNewUser: false,
};

const Login = () => {
	const { setUser } = useContext(AuthContext);

	const navigate = useNavigate();
	const handleOnClick = useCallback(() => navigate('/'), [navigate]);

	const UrlBase = process.env.REACT_APP_BASE_API_URL;

	const formik = useFormik({
		enableReinitialize: true,
		initialValues: {
			loginUsername: 'admin@database.com',
			loginPassword: '123456',
		},
		validate: (values) => {
			const errors: { loginUsername?: string; loginPassword?: string } = {};

			if (!values.loginUsername) {
				errors.loginUsername = 'Required';
			}

			if (!values.loginPassword) {
				errors.loginPassword = 'Required';
			}

			return errors;
		},
		validateOnChange: false,
		onSubmit: async (values) => {
			try {
				const response = await axios.post(`${UrlBase}login`, {
					"email": values.loginUsername, "password": values.loginPassword
				});
				if (response.status === 200) {
					if (setUser) {
						setUser(values.loginUsername);
					}
					localStorage.setItem('token', response.data.token);
					handleOnClick();
					// eslint-disable-next-line no-restricted-globals
					location.reload()
				} else {
					formik.setFieldError('loginPassword', 'Username and password do not match.');
				}
			} catch (error) {
				console.log({ error });
			}
		},
	});

	return (
		<PageWrapper
			isProtected={false}
			title='Login'
			className={classNames({ 'bg-dark': true })}>
			<Page className='p-0'>
				<div className='row h-100 align-items-center justify-content-center'>
					<div className='col-xl-4 col-lg-6 col-md-8 shadow-3d-container'>
						<Card className='shadow-3d-dark' data-tour='login-page'>
							<CardBody>
								<div className='text-center my-5'>
									<img src={logo} alt="Logo"
										className='logo'
										width={150}
									/>
								</div>
								<LoginHeader />
								<form className='row g-4'>

									<div className='col-12'>
										<FormGroup
											id='loginUsername'
											isFloating
											label='Your email or username'
										// className={classNames({
										// 	'd-none': signInPassword,
										// })}
										>
											<Input
												autoComplete='username'
												value={formik.values.loginUsername}
												isTouched={formik.touched.loginUsername}
												invalidFeedback={
													formik.errors.loginUsername
												}
												isValid={formik.isValid}
												onChange={formik.handleChange}
												onBlur={formik.handleBlur}
												onFocus={() => {
													formik.setErrors({});
												}}
											/>
										</FormGroup>
										<br />
										<FormGroup
											id='loginPassword'
											isFloating
											label='Password'
										>
											<Input
												type='password'
												autoComplete='current-password'
												value={formik.values.loginPassword}
												isTouched={formik.touched.loginPassword}
												invalidFeedback={
													formik.errors.loginPassword
												}
												validFeedback='Looks good!'
												isValid={formik.isValid}
												onChange={formik.handleChange}
												onBlur={formik.handleBlur}
											/>
										</FormGroup>
									</div>
									<div className='col-12'>

										<Button
											color='warning'
											className='w-100 py-3'
											onClick={formik.handleSubmit}>
											Login
										</Button>
									</div>

								</form>
							</CardBody>
						</Card>
					</div>
				</div>
			</Page>
		</PageWrapper>
	);
};
Login.defaultProps = {
	isSignUp: false,
};

export default Login;
