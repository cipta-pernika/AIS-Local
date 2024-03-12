<!DOCTYPE html>
<html>

<head>
    <title>Daily Report</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div>
        <h1 class="mt-4">Data Mandiri</h1>

        <table class="table">
            <thead>
                <tr>
                    <th>Total Kapal</th>
                    <th>Passing</th>
                    <th>Pandu</th>
                    <th>Bongkar Muat</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $summaryData['passing_count'] + $summaryData['pandu_count'] + $summaryData['bongkar_muat_count'] }}</td>
                    <td><span class="badge bg-primary">{{ $summaryData['passing_count'] }}</span></td>
                    <td><span class="badge bg-success">{{ $summaryData['pandu_count'] }}</span></td>
                    <td><span class="badge bg-danger">{{ $summaryData['bongkar_muat_count'] }}</span></td>
                </tr>
            </tbody>
        </table>


        <h2 class="mt-4">List Kapal</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Informasi Kapal</th>
                    <th>No PKK</th>
                    <th>Passing</th>
                    <th>Pandu</th>
                    <th>Bongkar Muat</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($addons as $key => $addon)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>
                        Nama Kapal: {{ $addon->aisDataVessel->vessel_name }} <br>
                        Tipe: {{ $addon->aisDataVessel->vessel_type }} <br>
                        MMSI: {{ $addon->aisDataVessel->mmsi }} <br>
                        Perusahaan: {{ $addon->aisDataVessel->nama_perusahaan }}
                    </td>
                    <td>{{ $addon->aisDataVessel->no_pkk }}</td>
                    <td>{{ $addon->isPassing ? 'Yes' : '' }}</td>
                    <td>{{ $addon->isPandu ? 'Yes' : '' }}</td>
                    <td>{{ $addon->isBongkarMuat ? 'Yes' : '' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>


        <!-- Add more content here as needed -->
    </div>
</body>

</html>