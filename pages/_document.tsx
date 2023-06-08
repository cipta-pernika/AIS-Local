import type { DocumentProps } from 'next/document';
import { Head, Html, Main, NextScript } from 'next/document';
import { GetStaticProps } from 'next';
import { serverSideTranslations } from 'next-i18next/serverSideTranslations';

const Document = ({ }: DocumentProps) => {
	return (
		<Html>
			<Head><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.min.css" integrity="sha512-h9FcoyWjHcOcmEVkxOfTLnmZFWIH0iZhZT1H2TbOq55xssQGEJHEaIm+PgoUaZbRvQTNTluNOEfb1ZRy6D3BOw==" crossOrigin="anonymous" referrerPolicy="no-referrer" /></Head>
			<body className='modern-design subheader-enabled'>
				<Main />
				<div id='portal-root'></div>
				<div id='portal-notification'></div>
				<NextScript />
			</body>
		</Html>
	);
};

export const getStaticProps: GetStaticProps = async ({ locale }) => ({
	props: {
		// @ts-ignore
		...(await serverSideTranslations(locale, ['translation', 'menu'])),
	},
});

export default Document;
