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

        .page-break {
            page-break-after: always;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="text-center mt-4">
            <img class="mb-5 img-fluid" src="{{asset('images/logo_apl_bjm2.png')}}" />
        </div>
        <h3 class="mb-4 mt-1 text-center">data</h3>
        {{$data}}
    </div>
</body>

</html>