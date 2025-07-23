{{-- resources/views/partials/sidebar.blade.php --}}
<aside
    x-data="{ openMaster: false, openUser: false, openPWA: false, openSystem: false, openAnalytics: false, openReport: false }"
    class="fixed top-16 left-0 bottom-0 w-64 bg-white border-r border-gray-200 overflow-y-auto z-10">

  {{-- Logo --}}
  <div class="px-4 py-4 border-b flex items-center">
    <x-heroicon-o-home class="h-7 w-7 text-indigo-600"/>
    <div class="ml-2">
      <span class="font-bold text-base leading-5">GeoSehat</span>
      <p class="text-xs text-gray-500">Pemantauan Kesehatan Geospasial</p>
    </div>
  </div>
  <div class="px-4 py-1 text-xs text-gray-400" id="now-datetime"></div>

  <nav class="mt-3 px-2 space-y-1 text-sm">

    <x-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')" class="flex items-center gap-3 px-4 py-2 rounded-md">
      <x-heroicon-o-home class="h-5 w-5"/> Dashboard Utama
    </x-nav-link>

    <x-nav-link href="{{ route('cases.index') }}" :active="request()->routeIs('cases.index')" class="flex items-center gap-3 px-4 py-2 rounded-md">
      <x-heroicon-o-document-text class="h-5 w-5"/> Kasus Management
    </x-nav-link>

    <x-nav-link href="{{ route('cases.map') }}" :active="request()->routeIs('cases.map')" class="flex items-center gap-3 px-4 py-2 rounded-md">
      <x-heroicon-o-document-text class="h-5 w-5"/> Peta Kasus
    </x-nav-link>

    {{-- Statistik & Laporan sebagai dropdown --}}
    <button @click="openAnalytics = !openAnalytics" class="w-full flex items-center gap-3 px-4 py-2 rounded-md text-gray-700 hover:bg-gray-100 focus:outline-none">
      <x-heroicon-o-chart-bar class="h-5 w-5"/> Statistik
      <x-heroicon-o-chevron-down class="h-4 w-4 ml-auto" x-bind:class="openAnalytics ? 'rotate-180' : ''"/>
    </button>
    <div x-show="openAnalytics" class="pl-12 space-y-1">
      <x-nav-link href="{{ route('analytics.trends') }}" :active="request()->routeIs('analytics.trends')" class="block px-4 py-2 rounded-md">
        Grafik Tren
      </x-nav-link>
      <x-nav-link href="{{ route('analytics.heatmap') }}" :active="request()->routeIs('analytics.heatmap')" class="block px-4 py-2 rounded-md">
        Heatmap
      </x-nav-link>
      <x-nav-link href="{{ route('analytics.predictive') }}" :active="request()->routeIs('analytics.predictive')" class="block px-4 py-2 rounded-md">
        Prediksi Kasus
      </x-nav-link>
    </div>

    <button @click="openReport = !openReport" class="w-full flex items-center gap-3 px-4 py-2 rounded-md text-gray-700 hover:bg-gray-100 focus:outline-none">
      <x-heroicon-o-document-text class="h-5 w-5"/> Laporan
      <x-heroicon-o-chevron-down class="h-4 w-4 ml-auto" x-bind:class="openReport ? 'rotate-180' : ''"/>
    </button>
    <div x-show="openReport" class="pl-12 space-y-1">
      <x-nav-link href="{{ route('reports.export') }}" :active="request()->routeIs('reports.export')" class="block px-4 py-2 rounded-md">
        Export Data
      </x-nav-link>
      <x-nav-link href="{{ route('reports.scheduled') }}" :active="request()->routeIs('reports.scheduled')" class="block px-4 py-2 rounded-md">
        Scheduled Reports
      </x-nav-link>
    </div>

    <x-nav-link href="{{ route('health_workers.index') }}" :active="request()->routeIs('health_workers.*')" class="flex items-center gap-3 px-4 py-2 rounded-md">
      <x-heroicon-o-user-group class="h-5 w-5"/> Tenaga Kesehatan
    </x-nav-link>

    {{-- Master Data --}}
    <button @click="openMaster = !openMaster"
      class="w-full flex items-center gap-3 px-4 py-2 rounded-md text-gray-700 hover:bg-gray-100 focus:outline-none">
      <x-heroicon-o-archive-box class="h-5 w-5"/> Master Data
      <x-heroicon-o-chevron-down class="h-4 w-4 ml-auto" x-bind:class="openMaster ? 'rotate-180' : ''"/>
    </button>
    <div x-show="openMaster" class="pl-12 space-y-1">
      <x-nav-link href="{{ route('diseases.index') }}" :active="request()->routeIs('diseases.index')" class="block px-4 py-2 rounded-md">
        Penyakit
      </x-nav-link>
      <x-nav-link href="{{ route('regions.index') }}" :active="request()->routeIs('regions.index')" class="block px-4 py-2 rounded-md">
        Wilayah
      </x-nav-link>
    </div>

    {{-- Manajemen Pengguna --}}
    <button @click="openUser = !openUser"
      class="w-full flex items-center gap-3 px-4 py-2 rounded-md text-gray-700 hover:bg-gray-100 focus:outline-none">
      <x-heroicon-o-users class="h-5 w-5"/> Manajemen Pengguna
      <x-heroicon-o-chevron-down class="h-4 w-4 ml-auto" x-bind:class="openUser ? 'rotate-180' : ''"/>
    </button>
    <div x-show="openUser" class="pl-12 space-y-1">
      <x-nav-link href="{{ route('users.index') }}" :active="request()->routeIs('users.*')" class="block px-4 py-2 rounded-md">
        Users
      </x-nav-link>
      <x-nav-link href="{{ route('security.2fa') }}" :active="request()->routeIs('security.2fa')" class="block px-4 py-2 rounded-md">
        2FA
      </x-nav-link>
    </div>

    <x-nav-link href="{{ route('notifications.index') }}" :active="request()->routeIs('notifications.index')" class="flex items-center gap-3 px-4 py-2 rounded-md">
      <x-heroicon-o-bell class="h-5 w-5"/>
      Notifikasi
      @if($unread??0)
        <span class="ml-auto text-xs font-semibold text-white bg-red-500 rounded-full px-2">{{ $unread }}</span>
      @endif
    </x-nav-link>

<x-nav-link href="{{ route('alerts.threshold.index') }}" :active="request()->routeIs('alerts.threshold.*')" class="flex items-center gap-3 px-4 py-2 rounded-md">
  <x-heroicon-o-adjustments-horizontal class="h-5 w-5"/> Threshold Alerts
</x-nav-link>

    </div>
  </nav>
</aside>

<script>
document.addEventListener('DOMContentLoaded', () => {
  const el = document.getElementById('now-datetime');
  function updateTime() {
    el.textContent = new Date().toLocaleString('en-GB', {
      weekday:'long', year:'numeric', month:'short',
      day:'numeric', hour:'2-digit', minute:'2-digit',
      hour12:false
    }).replace(',', ' —');
  }
  updateTime();
  setInterval(updateTime, 60000);
});
</script>
