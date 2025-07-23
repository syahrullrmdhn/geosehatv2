@extends('layouts.app')
@section('title', 'Peta Sebaran Kasus')

@push('styles')
<link
  rel="stylesheet"
  href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
  integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
  crossorigin=""
/>
<style>
  #mapKasus {
    height: 65vh;
    min-height: 480px;
    width: 100%;
    border-radius: 0.5rem;
    border: 1px solid #e5e7eb;
    z-index: 0;
  }
  .leaflet-container {
    font-family: inherit;
    background-color: #f9fafb;
  }
  .leaflet-popup-content {
    margin: 0.75rem;
  }
  .leaflet-popup-content-wrapper {
    border-radius: 0.375rem;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    border: 1px solid #e5e7eb;
  }
  .custom-marker svg {
    filter: drop-shadow(0 2px 2px rgba(0,0,0,0.1));
  }
</style>
@endpush

@section('content')
<div class="max-w-6xl mx-auto px-4 py-8">
  <section class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
    <div class="p-6">
      <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-4">
        <div>
          <h2 class="text-xl font-semibold text-gray-800">Peta Sebaran Kasus</h2>
          <p class="text-sm text-gray-500 mt-1">
            Visualisasi geografis kasus kesehatan per wilayah
          </p>
        </div>
        <div class="mt-3 sm:mt-0 bg-emerald-50 text-emerald-800 px-3 py-1 rounded-full text-xs">
          <span class="font-medium">Layer:</span> OpenStreetMap
        </div>
      </div>

      <div id="mapKasus" class="mt-4"></div>

      <div class="flex flex-wrap gap-4 mt-6 text-sm">
        <div class="flex items-center gap-2 px-3 py-1.5 bg-gray-50 rounded-full">
          <span class="inline-block h-3 w-3 rounded-full bg-red-500"></span>
          <span class="text-gray-700">Tinggi (>100 kasus)</span>
        </div>
        <div class="flex items-center gap-2 px-3 py-1.5 bg-gray-50 rounded-full">
          <span class="inline-block h-3 w-3 rounded-full bg-yellow-400"></span>
          <span class="text-gray-700">Sedang (50-100 kasus)</span>
        </div>
        <div class="flex items-center gap-2 px-3 py-1.5 bg-gray-50 rounded-full">
          <span class="inline-block h-3 w-3 rounded-full bg-green-500"></span>
          <span class="text-gray-700">Rendah (<50 kasus)</span>
        </div>
      </div>
    </div>
  </section>
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
  const rawCases = @json($cases);

  // Initialize map with better default view
  const map = L.map('mapKasus', {
    preferCanvas: true,
    zoomControl: false
  }).setView([-2.5489, 118.0149], 5);

  // Add zoom control with better position
  L.control.zoom({
    position: 'topright'
  }).addTo(map);

  // Add tile layer with retina support
  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>',
    maxZoom: 19,
    detectRetina: true
  }).addTo(map);

  // Marker clustering would be better here, but using simple markers for demo
  function getCaseLevel(count) {
    return count > 100
      ? { level: 'Tinggi', color: '#ef4444', className: 'high-cluster' }
      : count > 50
        ? { level: 'Sedang', color: '#f59e0b', className: 'medium-cluster' }
        : { level: 'Rendah', color: '#10b981', className: 'low-cluster' };
  }

  // Create markers
  rawCases.forEach(caseData => {
    const { level, color, className } = getCaseLevel(caseData.count);

    const icon = L.divIcon({
      className: `custom-marker ${className}`,
      html: `
        <svg width="32" height="32" viewBox="0 0 32 32">
          <circle cx="16" cy="16" r="12" fill="${color}" stroke="#fff" stroke-width="2"/>
          <text x="16" y="20" font-size="10" text-anchor="middle" fill="white" font-weight="bold">
            ${caseData.count}
          </text>
        </svg>`,
      iconSize: [32, 32],
      iconAnchor: [16, 16],
      popupAnchor: [0, -16]
    });

    const marker = L.marker([caseData.lat, caseData.lng], { icon })
      .addTo(map)
      .bindPopup(`
        <div class="min-w-[180px]">
          <h4 class="font-semibold text-gray-800">${caseData.region}</h4>
          <p class="text-sm text-gray-600">${caseData.disease}</p>
          <div class="flex items-center mt-2">
            <span class="inline-block w-2 h-2 rounded-full mr-2" style="background:${color}"></span>
            <span class="text-sm font-medium">${level}</span>
          </div>
          <div class="mt-1 text-sm text-gray-700">
            Total Kasus: <span class="font-semibold">${caseData.count}</span>
          </div>
          ${caseData.last_reported ? `
          <div class="mt-1 text-xs text-gray-500">
            Terakhir dilaporkan: ${new Date(caseData.last_reported).toLocaleDateString()}
          </div>` : ''}
        </div>
      `);

    marker.on('mouseover', function() {
      this.openPopup();
    });
  });

  // Adjust map after load
  setTimeout(() => {
    map.invalidateSize();
    if (rawCases.length > 0) {
      const markerGroup = new L.featureGroup(
        rawCases.map(c => L.latLng(c.lat, c.lng))
      );
      map.fitBounds(markerGroup.getBounds().pad(0.2));
    }
  }, 100);
});
</script>
@endpush
