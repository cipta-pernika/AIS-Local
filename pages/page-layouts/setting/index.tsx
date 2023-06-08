import type { NextPage } from 'next';
import { GetStaticProps } from 'next';
import Head from 'next/head';
import { serverSideTranslations } from 'next-i18next/serverSideTranslations';
import PageWrapper from '../../../layout/PageWrapper/PageWrapper';
import Page from '../../../layout/Page/Page';
import { useState } from 'react';
import FormGroup from '../../../components/bootstrap/forms/FormGroup';
import Input from '../../../components/bootstrap/forms/Input';
import Select from '../../../components/bootstrap/forms/Select';
import Checks from '../../../components/bootstrap/forms/Checks';
import Button from '../../../components/bootstrap/Button';

const Index: NextPage = () => {
	const [sensor, setSensor] = useState('');
	const [status, setStatus] = useState('');
	const [interval, setInterval] = useState('');
	const [jarak, setJarak] = useState('');
	const [jumlahData, setJumlahData] = useState('');

	const handleFormSubmit = (e: any) => {
		e.preventDefault();
		// Process the form data here
	};

	return (
		<PageWrapper>
			<Head>
				<title>Setting</title>
			</Head>
			<Page>
				<div className='row d-flex align-items-center h-100'>
					<div className="col-md-8">

						<form onSubmit={handleFormSubmit}>
							<FormGroup id='dataLogger' label='Data Logger'>
								<Input type="text" disabled />
							</FormGroup>

							<FormGroup id="sensor" label="Sensor">
								<Select
									value={sensor}
									onChange={(e: any) => setSensor(e.target.value)}
									ariaLabel='Sensor'
								>
									<option value="">Select Sensor</option>
									{/* Add your sensor options here */}
								</Select>
							</FormGroup>

							<FormGroup id="status" label="Status">
								<div>
									<Checks
										type="radio"
										label="Active"
										name="status"
										value="option1"
										checked={status === 'option1'}
										onChange={(e: any) => setStatus(e.target.value)}
									/>
									<Checks
										type="radio"
										label="Inactive"
										name="status"
										value="option2"
										checked={status === 'option2'}
										onChange={(e: any) => setStatus(e.target.value)}
									/>
									{/* Add more radio options if needed */}
								</div>
							</FormGroup>

							<FormGroup id="interval" label="Interval">
								<Select
									ariaLabel='Interval'
									value={interval}
									onChange={(e: any) => setInterval(e.target.value)}
								>
									<option value="">Select Interval</option>
									<option value="1 Minute">1 Minute</option>
									<option value="5 Minute">5 Minute</option>
									<option value="10 Minute">10 Minute</option>
									<option value="30 Minute">30 Minute</option>
									<option value="60 Minute">60 Minute</option>
									<option value="120 Minute">120 Minute</option>
								</Select>
							</FormGroup>

							<FormGroup id="jarak" label="Jarak">
								<Select
									ariaLabel='Jarak'
									value={jarak}
									onChange={(e: any) => setJarak(e.target.value)}
								>
									<option value="">Select Jarak</option>
									<option value="no limit">No Limit</option>
									<option value="1 NM">1 NM</option>
									<option value="5 NM">5 NM</option>
									<option value="10 NM">10 NM</option>
									<option value="20 NM">20 NM</option>
									<option value="50 NM">50 NM</option>
								</Select>
							</FormGroup>

							<FormGroup id="jumlahData" label="Jumlah Data">
								<Select
									ariaLabel='Jumlah Data'
									value={jumlahData}
									onChange={(e: any) => setJumlahData(e.target.value)}
								>
									<option value="">Select Jumlah Data</option>
									<option value="no limit">No Limit</option>
									<option value="10">10</option>
									<option value="25">25</option>
									<option value="50">50</option>
									<option value="100">100</option>
									<option value="200">200</option>
								</Select>
							</FormGroup> <Button type="submit">
								Submit
							</Button>
						</form>
					</div>
				</div>
			</Page>
		</PageWrapper>
	);
};

export const getStaticProps: GetStaticProps = async ({ locale }) => ({
	props: {
		// @ts-ignore
		...(await serverSideTranslations(locale, ['common', 'menu'])),
	},
});

export default Index;
