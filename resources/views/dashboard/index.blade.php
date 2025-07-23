@extends('layouts.app')
@section('title', 'Dashboard Pemantauan Kesehatan')

@push('styles')
<link
  rel="stylesheet"
  href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
  integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
  crossorigin=""
/>
<style>
  #mainMap {
    height: 400px;
    width: 100%;
    border-radius: 0.5rem;
    border: 1px solid #e5e7eb;
    z-index: 0;
  }
  .leaflet-container {
    font-family: inherit;
    background-color: #f9fafb;
  }
  .health-card {
    transition: all 0.3s ease;
    border-left: 4px solid;
  }
  .health-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.08);
  }
  .leaflet-popup-content-wrapper {
    border-radius: 0.375rem;
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    border: 1px solid #e5e7eb;
  }
  .custom-marker svg {
    filter: drop-shadow(0 2px 4px rgba(0,0,0,0.1));
  }
</style>
@endpush

@section('content')
<div class="min-h-screen bg-gray-50">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-6">
    {{-- Header --}}
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
      <div>
        <h1 class="text-2xl font-bold text-gray-900">Dashboard Pemantauan Kesehatan</h1>
        <p class="text-gray-600 mt-1">Ringkasan statistik dan pemantauan kasus terkini</p>
      </div>
      <div class="flex items-center gap-3">
        <div class="text-sm bg-white px-4 py-2 rounded-lg border border-gray-200 shadow-xs">
          <span class="text-gray-500">Update terakhir:</span>
          <span class="font-medium">{{ now()->format('d M Y, H:i') }}</span>
        </div>
        <button class="p-2 rounded-lg bg-white border border-gray-200 hover:bg-gray-50">
          <x-heroicon-s-arrow-right class="h-5 w-5 text-gray-500" />
        </button>
      </div>
    </div>

    {{-- Statistik Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
      @foreach($stats as $card)
      <div class="health-card bg-white rounded-xl p-5 shadow-sm border-l-{{ $card['color'] }}-500">
        <div class="flex items-center gap-4">
          <div class="p-3 rounded-lg bg-{{ $card['color'] }}-50">
            <x-heroicon-{{ $card['icon'] }} class="h-6 w-6 text-{{ $card['color'] }}-600" />
          </div>
          <div>
            <p class="text-2xl font-bold text-gray-800">{{ $card['value'] }}</p>
            <p class="text-sm text-gray-500">{{ $card['label'] }}</p>
            @if(isset($card['change']))
              <p class="text-xs mt-1 {{ $card['change']['direction'] === 'up' ? 'text-red-500' : 'text-green-500' }}">
                <span class="inline-flex items-center">
                  <x-heroicon-s-arrow-{{ $card['change']['direction'] }} class="h-3 w-3 mr-1" />
                  {{ $card['change']['value'] }}% dari bulan lalu
                </span>
              </p>
            @endif
          </div>
        </div>
      </div>
      @endforeach
    </div>

    {{-- Map and Charts Section --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
      {{-- Map Section --}}
      <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50 flex justify-between items-center">
          <div>
            <h3 class="font-semibold text-gray-800">Peta Sebaran Kasus</h3>
            <p class="text-sm text-gray-500">Lokasi kasus berdasarkan wilayah</p>
          </div>
          <div class="flex items-center gap-2">
            <div class="flex items-center gap-1 px-2 py-1 bg-gray-100 rounded text-xs">
              <span class="w-2 h-2 rounded-full bg-green-500"></span>
              <span>Rendah</span>
            </div>
            <div class="flex items-center gap-1 px-2 py-1 bg-gray-100 rounded text-xs">
              <span class="w-2 h-2 rounded-full bg-yellow-400"></span>
              <span>Sedang</span>
            </div>
            <div class="flex items-center gap-1 px-2 py-1 bg-gray-100 rounded text-xs">
              <span class="w-2 h-2 rounded-full bg-red-500"></span>
              <span>Tinggi</span>
            </div>
          </div>
        </div>
        <div class="p-6">
          <div id="mainMap"></div>
        </div>
      </div>

      {{-- Quick Stats --}}
      <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
          <h3 class="font-semibold text-gray-800">Distribusi Kasus</h3>
          <p class="text-sm text-gray-500">Berdasarkan jenis penyakit</p>
        </div>
        <div class="p-6">
          <div class="space-y-4">
            @foreach($diseaseDistribution as $disease)
            <div>
              <div class="flex justify-between text-sm mb-1">
                <span class="text-gray-700">{{ $disease['name'] }}</span>
                <span class="font-medium">{{ $disease['count'] }} kasus</span>
              </div>
              <div class="w-full bg-gray-200 rounded-full h-2">
                <div
                  class="h-2 rounded-full {{ $disease['color'] }}"
                  style="width: {{ ($disease['count'] / $diseaseDistribution->sum('count')) * 100 }}%">
                </div>
              </div>
            </div>
            @endforeach
          </div>
          <div class="mt-6 pt-6 border-t border-gray-200">
            <h4 class="text-sm font-medium text-gray-700 mb-3">Kasus per Wilayah</h4>
            <div class="space-y-3">
              @foreach($regionDistribution as $region)
              <div class="flex items-center justify-between text-sm">
                <span class="text-gray-600">{{ $region['name'] }}</span>
                <span class="font-medium">{{ $region['count'] }}</span>
              </div>
              @endforeach
            </div>
          </div>
        </div>
      </div>
    </div>

    {{-- Recent Cases --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
      <div class="px-6 py-4 border-b border-gray-200 bg-gray-50 flex justify-between items-center">
        <div>
          <h3 class="font-semibold text-gray-800">Kasus Terbaru</h3>
          <p class="text-sm text-gray-500">Daftar laporan kasus terkini</p>
        </div>
        <a href="{{ route('cases.index') }}" class="inline-flex items-center text-sm font-medium text-blue-600 hover:text-blue-800">
          Lihat Semua
          <x-heroicon-s-chevron-right class="ml-1 h-4 w-4" />
        </a>
      </div>
      <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Wilayah</th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Penyakit</th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah</th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            @forelse($latestCases as $c)
            <tr class="hover:bg-gray-50">
              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">#{{ $c['id'] }}</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $c['region'] }}</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $c['disease'] }}</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $c['count'] }}</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $c['date'] }}</td>
              <td class="px-6 py-4 whitespace-nowrap">
                @php
                  $statusColor = $c['count'] > 100 ? 'red' : ($c['count'] > 50 ? 'yellow' : 'green');
                @endphp
                <span class="px-2 py-1 text-xs rounded-full bg-{{ $statusColor }}-100 text-{{ $statusColor }}-800">
                  {{ $statusColor === 'red' ? 'Tinggi' : ($statusColor === 'yellow' ? 'Sedang' : 'Rendah') }}
                </span>
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="6" class="px-6 py-6 text-center text-gray-400">Belum ada data kasus.</td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script
  src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
  integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
  crossorigin=""
></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
  const data = @json($mapData);

  // Initialize map with better defaults
  const map = L.map('mainMap', {
    zoomControl: false,
    preferCanvas: true
  }).setView([-2.5489, 118.0149], 5);

  // Add custom zoom control
  L.control.zoom({
    position: 'topright'
  }).addTo(map);

  // Add tile layer
  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>',
    maxZoom: 19,
    detectRetina: true
  }).addTo(map);

  // Color scale function
  function getColor(count) {
    return count > 100 ? '#ef4444' :
           count > 50 ? '#f59e0b' :
           '#10b981';
  }

  // Add markers with better popups
  data.forEach(loc => {
    const color = getColor(loc.count);
    const status = loc.count > 100 ? 'Tinggi' : loc.count > 50 ? 'Sedang' : 'Rendah';

    const icon = L.divIcon({
      className: 'custom-marker',
      html: `
        <svg width="32" height="32" viewBox="0 0 32 32">
          <circle cx="16" cy="16" r="12" fill="${color}" stroke="#fff" stroke-width="2"/>
          <text x="16" y="20" font-size="10" text-anchor="middle" fill="white" font-weight="bold">
            ${loc.count}
          </text>
        </svg>`,
      iconSize: [32, 32],
      iconAnchor: [16, 16],
      popupAnchor: [0, -16]
    });

    L.marker([loc.lat, loc.lng], { icon })
      .addTo(map)
      .bindPopup(`
        <div class="min-w-[180px]">
          <h4 class="font-semibold text-gray-800">${loc.region}</h4>
          <div class="flex items-center mt-1">
            <span class="inline-block w-2 h-2 rounded-full mr-2" style="background:${color}"></span>
            <span class="text-sm font-medium">${status}</span>
          </div>
          <div class="mt-1 text-sm text-gray-700">
            Total Kasus: <span class="font-semibold">${loc.count}</span>
          </div>
        </div>
      `);
  });

  // Fit bounds if there are markers
  if (data.length > 0) {
    const markerGroup = new L.featureGroup(
      data.map(loc => L.latLng(loc.lat, loc.lng))
    );
    map.fitBounds(markerGroup.getBounds().pad(0.2));
  }

  // Fix map sizing
  setTimeout(() => map.invalidateSize(), 100);
});
</script>
@endpush
