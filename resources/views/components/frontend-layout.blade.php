@props([
    'title' => null,
    'description' => null,
    'keywords' => null,
    'image' => null,
    'canonical' => null,
    'ogType' => 'website',
    'robots' => 'index,follow',
])
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name="robots" content="{{ $robots }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @php
        $seoTitle = $title ?? 'TechNova Nepal';
        $seoDescription = $description ?? 'Buy genuine laptops, gadgets and accessories in Nepal. TechNova Nepal — Kathmandu.';
        $seoKeywords = $keywords ?? 'laptop Nepal, gadgets Kathmandu, TechNova Nepal';
        $seoImage = $image ?? asset('image/logo.png');
        $seoUrl = $canonical ?? url()->current();
    @endphp

    <title>{{ $seoTitle }}</title>
    <meta name="description" content="{{ $seoDescription }}">
    <meta name="keywords" content="{{ $seoKeywords }}">
    <link rel="canonical" href="{{ $seoUrl }}">

    <meta property="og:type" content="{{ $ogType ?? 'website' }}">
    <meta property="og:site_name" content="TechNova Nepal">
    <meta property="og:title" content="{{ $seoTitle }}">
    <meta property="og:description" content="{{ $seoDescription }}">
    <meta property="og:image" content="{{ $seoImage }}">
    <meta property="og:url" content="{{ $seoUrl }}">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $seoTitle }}">
    <meta name="twitter:description" content="{{ $seoDescription }}">
    <meta name="twitter:image" content="{{ $seoImage }}">

    {{ $schema ?? '' }}

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
