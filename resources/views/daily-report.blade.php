<!-- resources/views/daily-report.blade.php -->

<!DOCTYPE html>
<html>
<head>
    <title>Daily Report</title>
</head>
<body>
    <h1>Daily Report</h1>
    
    <p>Total Kapal: {{ $jumlahkapal }}</p>
    <p>Total Pesawat: {{ $jumlahpesawat }}</p>
    <p>Radar Image URL: {{ $radar_image_url }}</p>
    
    <h2>Jumlah Kapal by Type</h2>
    <ul>
        @foreach ($jumlahkapalByType as $kapalType)
            <li>{{ $kapalType->vessel_type }}: {{ $kapalType->count }}</li>
        @endforeach
    </ul>
    
    <!-- Add more content here as needed -->
</body>
</html>
