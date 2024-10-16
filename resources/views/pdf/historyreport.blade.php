<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>

        .table-bordered thead {
            border-color: transparent !important;
        }
        .table-bordered th {
            background-color: #5498fe;
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
            padding: 6px 4px;
            font-size: 12px;
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
                        <th>Sensor Data</th>
                        <th>Vessel ID</th>
                        <th>Latitude</th>
                        <th>Longitude</th>
                        <th>Speed</th>
                        <th>Course</th>
                        <th>Heading</th>
                        <th>Nav Status</th>
                        <th>Turn Rate</th>
                        <th>Turn Direction</th>
                        <th>Timestamp</th>
                        <th>Distance</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $item)
                        <tr>
                            <td>{{ $item->sensor_data_id }}</td>
                            <td>{{ $item->vessel_id }}</td>
                            <td>{{ $item->latitude }}</td>
                            <td>{{ $item->longitude }}</td>
                            <td>{{ $item->speed }}</td>
                            <td>{{ $item->course }}</td>
                            <td>{{ $item->heading }}</td>
                            <td>{{ $item->navigation_status }}</td>
                            <td>{{ $item->turning_rate }}</td>
                            <td>{{ $item->turning_direction }}</td>
                            <td>{{ $item->timestamp }}</td>
                            <td>{{ $item->distance }}</td>
                        </tr>
                    @endforeach
                    <tr>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>