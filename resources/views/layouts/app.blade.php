<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-gray-50 font-sans">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard GeoSehat')</title>
    <meta name="description" content="@yield('description', 'Pemantauan Kesehatan Geospasial')">

    {{-- Load CSS dari Laravel Mix --}}
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">

    {{-- Stack untuk styles tambahan per halaman --}}
    @stack('styles')

    <style>
        [x-cloak] { display: none !important; }
        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar-open { transform: translateX(0); }
            .main-content { margin-left: 0 !important; }
        }
    </style>
</head>
<body class="h-full antialiased bg-gray-50">
    @auth
        {{-- Topbar --}}
        @include('partials.topbar')

        {{-- Sidebar --}}
        @include('partials.sidebar')
    @endauth

    {{-- Main content --}}
    <main class="lg:ml-64 mt-16 p-6 transition-all duration-300 main-content">
        @if(session('success'))
            <div class="mb-4 px-4 py-2 text-sm text-green-700 bg-green-100 rounded">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="mb-4 px-4 py-2 text-sm text-red-700 bg-red-100 rounded">
                {{ session('error') }}
            </div>
        @endif
        @yield('content')
    </main>

    {{-- Load JS dari Laravel Mix --}}
    <script src="{{ mix('js/app.js') }}" defer></script>
    @stack('scripts')
</body>
</html>
