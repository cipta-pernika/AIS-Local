<!-- resources/views/daily-report.blade.php -->

<!DOCTYPE html>
<html>
<head>
    <title>Daily Report</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1 class="mt-4">Daily Report</h1>
        
        <p>Total Kapal: {{ $jumlahkapal }}</p>
        <p>Total Pesawat: {{ $jumlahpesawat }}</p>
        <p>Radar Image URL: {{ $radar_image_url }}</p>
        <p>Total Radar Data: {{ $jumlahradardata }}</p>
        
        <h2 class="mt-4">Jumlah Kapal by Type</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Vessel Type</th>
                    <th>Count</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($jumlahkapalByType as $kapalType)
                    <tr>
                        <td>{{ $kapalType->vessel_type }}</td>
                        <td>{{ $kapalType->count }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        
        <!-- Add more content here as needed -->
    </div>
</body>
</html>
