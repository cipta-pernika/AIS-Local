<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        .table-bordered th,
        .table-bordered td {
            border: 1px solid #ddd !important
        }
    </style>
</head>

<body>
    <div class="container mt-4">
    <div class="d-flex justify-content-center align-items-center" style="background-color: #1d404a; height: 150px;">
            <img class="img-fluid" src="{{asset('images/logo_apl_bjm2.png')}}" />
        </div>
        <h1 class="mb-4 mt-1 text-center">Summary Report</h1>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Keterangan</th>
                    <th>Jumlah</th>
                    <th>Link</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Jumlah Kapal</td>
                    <td>{{ isset($total_kapal) ? $total_kapal : '0' }}</td>
                    <td rowspan="9"><a href="https://sopbuntutksopbjm.com/reports">View Detail</a></td>
                </tr>
                <tr>
                    <td>Kapal Passing</td>
                    <td>{{ isset($summaryData['passing_count']) ? $summaryData['passing_count'] : '0' }}</td>
                </tr>
                <tr>
                    <td>Kapal Anchor</td>
                    <td>{{ isset($summaryData['anchor_count']) ? $summaryData['anchor_count'] : '0' }}</td>
                </tr>
                <tr>
                    <td>Data Rencana Pandu</td>
                    <td>{{ isset($summaryData['pandu_count']) && isset($summaryData['pandu_count']['detail']['terlambat']) ? $summaryData['pandu_count']['detail']['terlambat'] : '' }}</td>

                </tr>
                <tr>
                    <td>Data Realtime Pandu</td>
                    <td>{{ isset($summaryData['pandu_count']) && isset($summaryData['pandu_count']['detail']['tidak_terjadwal']) ? $summaryData['pandu_count']['detail']['tidak_terjadwal'] : '' }}</td>

                </tr>
                <tr>
                    <td>Pandu Tervalidasi</td>
                    <td>{{ isset($summaryData['pandu_count']) && isset($summaryData['pandu_count']['detail']['valid']) ? $summaryData['pandu_count']['detail']['valid'] : '' }}</td>

                </tr>
                <tr>
                    <td>Rencana Bongkar Muat</td>
                    <td>{{ isset($summaryData['bongkar_muat_count']) && isset($summaryData['bongkar_muat_count']['detail']['terlambat']) ? $summaryData['bongkar_muat_count']['detail']['terlambat'] : '' }}</td>

                </tr>
                <tr>
                    <td>Realtime Bongkar Muat</td>
                    <td>{{ isset($summaryData['bongkar_muat_count']) && isset($summaryData['bongkar_muat_count']['detail']['tidak_terjadwal']) ? $summaryData['bongkar_muat_count']['detail']['tidak_terjadwal'] : '' }}</td>

                </tr>
                <tr>
                    <td>Bongkar Muat Tervalidasi</td>
                    <td>{{ isset($summaryData['bongkar_muat_count']) && isset($summaryData['bongkar_muat_count']['detail']['valid']) ? $summaryData['bongkar_muat_count']['detail']['valid'] : '' }}</td>

                </tr>
                <tr>
                    <td>Tongkang dipasangkan dengan Tug Boat</td>
                    <td>{{ isset($summaryData['totalpaired']) ? $summaryData['totalpaired'] : '0' }}</td>
                    <td><a href="https://backend.sopbuntutksopbjm.com/admin/barge-paired-with-tug-boat">Admin Link</a></td>
                </tr>
            </tbody>
        </table>
        <h2 class="mt-5 text-center">PNBP</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Jenis PNBP</th>
                    <th>Jumlah</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>PNBP Jasa Labuh Kapal</td>
                    <td>Rp. {{ number_format($summaryData->total_pnbp_jasa_labuh_kapal, 2, ',', '.') }}</td>
                </tr>
                <tr>
                    <td>PNBP Jasa Rambu Kapal</td>
                    <td>Rp. {{ number_format($summaryData->total_pnbp_jasa_rambu_kapal, 2, ',', '.') }}</td>
                </tr>
                <tr>
                    <td>PNBP Jasa VTS Kapal Domestik</td>
                    <td>Rp. {{ number_format($summaryData->total_pnbp_jasa_vts_kapal_domestik, 2, ',', '.') }}</td>
                </tr>
                <tr>
                    <td>PNBP Jasa VTS Kapal Asing</td>
                    <td>Rp. {{ number_format($summaryData->total_pnbp_jasa_vts_kapal_asing, 2, ',', '.') }}</td>
                </tr>
                <tr>
                    <td>PNBP Jasa Tambat Kapal</td>
                    <td>Rp. {{ number_format($summaryData->total_pnbp_jasa_tambat_kapal, 2, ',', '.') }}</td>
                </tr>
                <tr>
                    <td>PNBP Jasa Pemanduan Penundaan Marabahan</td>
                    <td>Rp. {{ number_format($summaryData->total_pnbp_jasa_pemanduan_penundaan_marabahan, 2, ',', '.') }}</td>
                </tr>
                <tr>
                    <td>PNBP Jasa Pemanduan Penundaan Trisakti</td>
                    <td>Rp. {{ number_format($summaryData->total_pnbp_jasa_pemanduan_penundaan_trisakti, 2, ',', '.') }}</td>
                </tr>
                <tr>
                    <td>PNBP Jasa Barang</td>
                    <td>Rp. {{ number_format($summaryData->total_pnbp_jasa_barang, 2, ',', '.') }}</td>
                </tr>
                <tr>
                    <td>PNBP Jasa Pengawasan Bongkar Muat 1%</td>
                    <td>Rp. {{ number_format($summaryData->total_pnbp_jasa_pengawasan_bongkar_muat_1_percent, 2, ',', '.') }}</td>
                </tr>
                <tr>
                    <td>PNBP Bongkar Muat Barang Berbahaya</td>
                    <td>Rp. {{ number_format($summaryData->total_pnbp_bongkar_muat_barang_berbahaya, 2, ',', '.') }}</td>
                </tr>
                <tr>
                    <td>Total</td>
                    <td>Rp. {{ number_format($summaryData->total_pnbp_jasa_labuh_kapal + $summaryData->total_pnbp_jasa_rambu_kapal + $summaryData->total_pnbp_jasa_vts_kapal_domestik + $summaryData->total_pnbp_jasa_vts_kapal_asing + $summaryData->total_pnbp_jasa_tambat_kapal + $summaryData->total_pnbp_jasa_pemanduan_penundaan_marabahan + $summaryData->total_pnbp_jasa_pemanduan_penundaan_trisakti + $summaryData->total_pnbp_jasa_barang + $summaryData->total_pnbp_jasa_pengawasan_bongkar_muat_1_percent + $summaryData->total_pnbp_bongkar_muat_barang_berbahaya, 2, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</body>

</html>