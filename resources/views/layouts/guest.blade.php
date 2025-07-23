<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>@yield('title', config('app.name', 'Laravel'))</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Mulish:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link href="{{ mix('css/app.css') }}" rel="stylesheet">
  <style>
    body { font-family: 'Mulish', sans-serif; }
  </style>
</head>
<body class="min-h-screen bg-gray-50 flex items-center justify-center antialiased">
  <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
    <div class="w-[500px] h-[500px] rounded-full bg-blue-100 opacity-60 blur-[110px]"></div>
  </div>
  <main class="relative z-10 w-full max-w-md mx-auto">
    @yield('content')
  </main>
  <script src="{{ mix('js/app.js') }}" defer></script>
</body>
</html>
