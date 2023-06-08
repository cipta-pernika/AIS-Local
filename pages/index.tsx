import React, { useContext, useEffect, useState } from 'react';
import type { NextPage } from 'next';
import { GetStaticProps } from 'next';
import Head from 'next/head';
import { serverSideTranslations } from 'next-i18next/serverSideTranslations';
import PageWrapper from '../layout/PageWrapper/PageWrapper';
import SubHeader, {
	SubHeaderLeft,
	SubHeaderRight,
	SubheaderSeparator,
} from '../layout/SubHeader/SubHeader';
import { useTour } from '@reactour/tour';
import ThemeContext from '../context/themeContext';
import useDarkMode from '../hooks/useDarkMode';
import Page from '../layout/Page/Page';
import Popovers from '../components/bootstrap/Popovers';
import dynamic from "next/dynamic"

const Maps = dynamic(() => import("../components/Maps"), { ssr:false })

const Index: NextPage = () => {
	const { mobileDesign } = useContext(ThemeContext);

	const { setIsOpen } = useTour();

	useEffect(() => {
		if (
			typeof window !== 'undefined' &&
			localStorage.getItem('tourModalStarted') !== 'shown' &&
			!mobileDesign
		) {
			setTimeout(() => {
				setIsOpen(true);
				localStorage.setItem('tourModalStarted', 'shown');
			}, 3000);
		}
		return () => { };
		// eslint-disable-next-line react-hooks/exhaustive-deps
	}, []);

	const { themeStatus } = useDarkMode();

	return (
		<PageWrapper>
			<Head>
				<title>Dashboard Page</title>
			</Head>
			<SubHeader>
				<SubHeaderLeft>
					<Popovers title='index.tsx' desc={<code>pages/index.tsx</code>}>
						SubHeaderLeft
					</Popovers>
					<code>index.tsx</code>
					<SubheaderSeparator />
				</SubHeaderLeft>
				<SubHeaderRight>
					<Popovers title='index.tsx' desc={<code>pages/index.tsx</code>}>
						SubHeaderRight
					</Popovers>
					<code>index.tsx</code>
				</SubHeaderRight>
			</SubHeader>
			<Page>
				<div className='row'>
					<div className='col-12 mb-3'>
						<Maps />
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
