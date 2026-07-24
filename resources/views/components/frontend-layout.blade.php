<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
<<<<<<< HEAD
    <title>Document</title>
   @vite(['resources/css/app.css', 'resources/js/app.js'])
=======
    <title>Technova Nepal</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
>>>>>>> 684e337a42f6be846c909ceec0e1da05e0760c41

    <link rel="stylesheet" href="{{ asset('frontend/style.css') }}">
    <style>
        .container{
                width: 97%;
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
