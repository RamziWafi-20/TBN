<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'TBN — Trash Bank Neskar | Bank Sampah Sekolah Digital')</title>

    {{-- SEO Meta --}}
    <meta name="description" content="@yield('meta_description', 'TBN mengubah sampah sekolah jadi nilai: AI Waste Scanner, Eco AI, pelaporan sampah, dan analitik Waste to Value.')">
    <meta property="og:type" content="website">
    <meta property="og:title" content="@yield('og_title', 'TBN — Trash Bank Neskar')">
    <meta property="og:description" content="@yield('og_description', 'Bank sampah sekolah digital: pindai, laporkan, dan ubah sampah menjadi nilai.')">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('twitter_title', 'TBN — Trash Bank Neskar')">
    <meta name="twitter:description" content="@yield('twitter_description', 'Bank sampah sekolah digital: pindai, laporkan, dan ubah sampah menjadi nilai.')">

    {{-- Favicon --}}
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Sora:wght@500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap">

    {{-- Styles --}}
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    {{-- Preload hero image --}}
    @hasSection('preload')
        @yield('preload')
    @endif

    @stack('head')
</head>
<body>
    @include('partials.header')

    @yield('content')

    @include('partials.footer')

    @stack('scripts')
</body>
</html>
