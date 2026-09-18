<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Technova Nepal</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('frontend/style.css') }}">
    <style>
        .Container {
            width: 97%;
            height: 100%;
            margin-left: auto;
            margin-right: auto;
        }

       
        @media (max-width: 640px) {
            .Container {
                width: 94%;
            }
        }


        @media (min-width: 1536px) {
            .Container {
                max-width: 1400px;
            }
        }
    </style>
</head>
<body class="min-h-screen flex flex-col bg-white text-[#111827] overflow-x-hidden antialiased">

    <x-frontend-header />

    <main class="flex-1 w-full">
        {{ $slot }}
    </main>

    <x-frontend-footer />

</body>
</html>
