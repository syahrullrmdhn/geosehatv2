<#
.SYNOPSIS
  Scaffold Admin Blade Views: layout, topbar, sidebar & view stubs.

.DESCRIPTION
  - layouts/app.blade.php
  - partials/topbar.blade.php
  - partials/sidebar.blade.php
  - resources/views/{folder}/{index,create,edit}.blade.php
#>

param()

# Pastikan dijalankan dari project root
if (-not (Test-Path .\artisan)) {
    Write-Error "Harus dijalankan di folder root Laravel (di mana artisan berada)."
    exit 1
}

# Function untuk menulis file jika belum ada
function Write-IfMissing($path, $content) {
    if (-not (Test-Path $path)) {
        New-Item -ItemType File -Path $path -Force | Out-Null
        Set-Content -Path $path -Value $content -Encoding UTF8
        Write-Host "Created: $path"
    } else {
        Write-Host "Skipped (exists): $path"
    }
}

# 1. layouts/app.blade.php
$layoutPath = "resources\views\layouts\app.blade.php"
$layoutStub = @'
<!DOCTYPE html>
<html lang="{{ str_replace('_','-',app()->getLocale()) }}" class="h-full bg-gray-50 font-sans">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>@yield('title','Dashboard GeoSehat')</title>
  <meta name="description" content="@yield('description','Pemantauan Kesehatan Geospasial')">

  <link href="{{ mix('css/app.css') }}" rel="stylesheet">
  <style>[x-cloak]{display:none!important}</style>
</head>
<body class="h-full antialiased bg-gray-50">

  @auth
    @include('partials.topbar')
    @include('partials.sidebar')
  @endauth

  <main class="ml-64 mt-16 p-6 min-h-[calc(100vh-4rem)] overflow-auto">
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

  <script src="{{ mix('js/app.js') }}" defer></script>
  @stack('scripts')
</body>
</html>
'@
Write-IfMissing $layoutPath $layoutStub

# 2. partials/topbar.blade.php
$topbarPath = "resources\views\partials\topbar.blade.php"
$topbarStub = @'
<header class="fixed top-0 left-0 right-0 h-16 px-6 bg-white border-b border-gray-200 flex items-center z-20">
  <h1 class="text-xl font-semibold text-gray-900">
    @yield('title','Dashboard GeoSehat')
  </h1>
  <div class="ml-auto flex items-center space-x-4">
    <button class="relative p-1 text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 rounded-full">
      <x-heroicon-o-bell class="h-6 w-6"/>
      @if(auth()->user()->unreadNotifications()->count() > 0)
        <span class="absolute top-0 right-0 block h-2.5 w-2.5 bg-red-500 rounded-full ring-2 ring-white"></span>
      @endif
    </button>
    <div x-data="{ open:false }" class="relative">
      <button @click="open=!open" class="flex items-center space-x-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
        <img src="{{ auth()->user()->profile_photo_url }}" alt="{{ auth()->user()->name }}" class="h-8 w-8 rounded-full"/>
        <span class="text-gray-700">{{ auth()->user()->name }}</span>
        <x-heroicon-o-chevron-down class="h-4 w-4 text-gray-500"/>
      </button>
      <div x-show="open" @click.away="open=false" x-transition
           class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5 z-20" x-cloak>
        <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
          Profil Anda
        </a>
        <form method="POST" action="{{ route('logout') }}">
          @csrf
          <button type="submit" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
            Keluar
          </button>
        </form>
      </div>
    </div>
  </div>
</header>
'@
Write-IfMissing $topbarPath $topbarStub

# 3. partials/sidebar.blade.php
$sidebarPath = "resources\views\partials\sidebar.blade.php"
$sidebarStub = @'
@php $unread = auth()->user()->unreadNotifications()->count(); @endphp

<aside class="fixed top-16 left-0 bottom-0 w-64 bg-white border-r border-gray-200 overflow-y-auto z-10">
  <div class="px-4 py-4 border-b">
    <div class="flex items-center">
      <x-heroicon-o-home class="h-6 w-6 text-indigo-600"/>
      <div class="ml-2">
        <h2 class="text-lg font-semibold">GeoSehat</h2>
        <p class="text-xs text-gray-500">Pemantauan Kesehatan Geospasial</p>
      </div>
    </div>
    <time id="now-datetime" class="mt-2 block text-xs text-gray-500"></time>
  </div>

  <nav class="mt-4 space-y-1 px-2 pb-4">
    @foreach([
       ['route'=>'dashboard','icon'=>'o-home','label'=>'Dashboard'],
       ['route'=>'cases.index','icon'=>'o-document-text','label'=>'Daftar Kasus'],
       ['route'=>'cases.create','icon'=>'o-plus-circle','label'=>'Input Data Kasus'],
       ['route'=>'cases.map','icon'=>'o-map','label'=>'Peta Kasus'],
       ['route'=>'alerts.threshold','icon'=>'o-adjustments-horizontal','label'=>'Threshold Alerts'],
       ['route'=>'notifications.index','icon'=>'o-bell','label'=>'Notifikasi','badge'=>$unread],
       ['route'=>'reports.export','icon'=>'o-arrow-down-tray','label'=>'Export Data'],
       ['route'=>'reports.scheduled','icon'=>'o-calendar-days','label'=>'Scheduled Reports'],
       ['route'=>'analytics.trends','icon'=>'o-chart-bar','label'=>'Grafik Tren'],
       ['route'=>'analytics.heatmap','icon'=>'o-fire','label'=>'Heatmap'],
       ['route'=>'analytics.predictive','icon'=>'o-light-bulb','label'=>'Prediksi Kasus'],
       ['route'=>'diseases.index','icon'=>'o-heart','label'=>'Penyakit'],
       ['route'=>'regions.index','icon'=>'o-globe-alt','label'=>'Wilayah'],
       ['route'=>'roles.index','icon'=>'o-users','label'=>'Role & Permission'],
       ['route'=>'security.2fa','icon'=>'o-lock-closed','label'=>'2FA'],
       ['route'=>'api.docs','icon'=>'o-code-bracket-square','label'=>'API Docs'],
       ['route'=>'webhooks.index','icon'=>'o-wifi','label'=>'Webhooks'],
       ['route'=>'pwa.settings','icon'=>'o-device-phone-mobile','label'=>'PWA Settings'],
       ['route'=>'pwa.offline','icon'=>'o-arrow-path','label'=>'Offline Sync'],
       ['route'=>'audit.index','icon'=>'o-magnifying-glass-circle','label'=>'Audit'],
       ['route'=>'backup.index','icon'=>'o-cloud-arrow-up','label'=>'Backup'],
       ['route'=>'privacy.index','icon'=>'o-shield-check','label'=>'Privacy'],
    ] as $item)
      @php $active = request()->routeIs(str_replace(\'.\',\'*\',$item[\'route\'])); @endphp
      <a href="{{ route($item[\'route\']) }}"
         class="relative group flex items-center gap-3 px-4 py-2 text-sm font-medium rounded-md transition-colors
                {{ \$active
                    ? \'bg-indigo-50 text-indigo-700\'
                    : \'text-gray-700 hover:bg-gray-100 hover:text-gray-900\' }}">
        <x-heroicon-{{ \$item[\'icon\'] }} class="h-5 w-5"/>
        <span>{{ \$item[\'label\'] }}</span>
        @if(!empty(\$item[\'badge\']))
          <span class="absolute right-4 inline-flex items-center justify-center px-2 py-0.5 text-xs font-semibold text-white bg-red-500 rounded-full">
            {{ \$item[\'badge\'] }}
          </span>
        @endif
      </a>
    @endforeach
  </nav>
</aside>

<script>
document.addEventListener('DOMContentLoaded', () => {
  const el = document.getElementById('now-datetime');
  const update = () => {
    el.textContent = new Date().toLocaleString('en-GB', {
      weekday:'long', year:'numeric', month:'short',
      day:'numeric', hour:'2-digit', minute:'2-digit',
      hour12:false
    }).replace(',', ' —');
  };
  update(); setInterval(update, 60000);
});
</script>
'@
Write-IfMissing $sidebarPath $sidebarStub

# 4. Generate view stubs
$viewBase = "resources\views"
$skip = @('layouts','partials','components','icons','auth')
$dirs = Get-ChildItem -Path $viewBase -Directory | Where-Object { $skip -notcontains $_.Name }

foreach ($dir in $dirs) {
    $base = $dir.Name
    $verbs = @{
        index  = "Daftar $base"
        create = "Tambah $base"
        edit   = "Edit $base"
    }
    foreach ($action in 'index','create','edit') {
        $file = "$($dir.FullName)\$action.blade.php"
        if (-not (Test-Path $file)) {
            $stub = @"
{{-- resources/views/$base/$action.blade.php --}}
@extends('layouts.app')

@section('title','$($verbs[$action])')

@section('content')
<div class="space-y-4">
  <h2 class="text-2xl font-semibold">$($verbs[$action])</h2>
  <!-- TODO: $action for $base -->
</div>
@endsection
"@
            Set-Content -Path $file -Value $stub -Encoding UTF8
            Write-Host "Created view stub: $base/$action.blade.php"
        }
    }
}

Write-Host "👍 Scaffold complete!"
