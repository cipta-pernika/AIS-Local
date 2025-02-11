<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

<<<<<<< HEAD
    <title inertia>{{ config('app.name', 'Laravel') }}</title>
=======
    <title inertia>{{ config('app.name', 'AIS') }}</title>
>>>>>>> 7eb5fa95ee0e9673a32ac9f983bf31377e7e1c02

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
<<<<<<< HEAD

    <!-- Scripts -->
    @routes
    @viteReactRefresh
    @vite(['public/frontend/src/index.tsx'])
=======
    <!-- Scripts -->
    @routes
    @viteReactRefresh
>>>>>>> 7eb5fa95ee0e9673a32ac9f983bf31377e7e1c02
    @inertiaHead
</head>

<body class="font-sans antialiased">
    @inertia
</body>

</html>