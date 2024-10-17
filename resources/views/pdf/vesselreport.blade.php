<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Bootstrap demo</title>
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
        crossorigin="anonymous" />
    <style>
        body {
            font-family: 'Arial', sans-serif;
        }

        .table-bordered thead,
        .table-bordered tbody {
            border-color: transparent !important;
        }

        .table-bordered th {
            background-color: #183f79;
            color: #fff;
        }

        .table-bordered tr th:first-child {
            border-radius: 6px 0 0 0;
        }

        .table-bordered tr th:last-child {
            border-radius: 0 6px 0 0;
        }

        .table-bordered th,
        .table-bordered td {
            /* border: 1px solid #ddd !important; */
            padding: 8px;
            font-size: 12px;
        }

        .table-bordered tbody tr:nth-child(odd) td {
            background-color: #ffffff;
            /* or any other color you prefer */
        }

        .table-bordered tbody tr:nth-child(even) td {
            background-color: #ebebeb;
        }

        .page-break {
            page-break-after: always;
        }

        @page {
            size: landscape;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="text-center mt-4">
            <h3 class="mb-4 mt-1 text-center">History Report</h3>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Vessel Name</th>
                        <th>Vessel Type</th>
                        <th>MMSI</th>
                        <th>IMO</th>
                        <th>Callsign</th>
                        <th>Nama Negara</th>
                        <th>Tipe Kapal</th>
                        <th>Nama Perusahaan</th>
                        <th>GT Kapal</th>
                        <th>Jenis Layanan</th>
                        <th>Dwt</th>
                        <th>Nakhoda</th>
                        
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $item)
                    <tr>
                        <td>{{ $item->vessel_name }}</td>
                        <td>{{ $item->vessel_type }}</td>
                        <td>{{ $item->mmsi }}</td>
                        <td>{{ $item->imo }}</td>
                        <td>{{ $item->callsign }}</td>
                        <td>{{ $item->nama_negara }}</td>
                        <td>{{ $item->tipe_kapal }}</td>
                        <td>{{ $item->nama_perusahaan }}</td>
                        <td>{{ $item->gt_kapal }}</td>
                        <td>{{ $item->jenis_layanan }}</td>
                        <td>{{ $item->dwt }}</td>
                        <td>{{ $item->nakhoda }}</td>
                        
                    </tr>

                    @endforeach
                    <tr></tr>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>