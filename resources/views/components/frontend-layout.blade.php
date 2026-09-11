<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Technova Nepal</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('frontend/style.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        .Container{
                width:97%;
                height:100%;
            }
    </style>
</head>
<body>
    <x-frontend-header />

        <main>
            {{ $slot }}
        </main>
    <x-frontend-footer />

</body>
</html>
