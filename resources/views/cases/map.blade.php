@extends('layouts.app')
@section('title', 'Peta Kasus')

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
<style>
    #mapKasus {
        min-height: 420px;
        height: 48vh;
        width: 100%;
        border-radius: 0.75rem;
        border: 1px solid #e5e7eb; /* gray-200 */
        margin-bottom: 1.5rem;
        z-index: 0;
    }
    .leaflet-control {
        font-family: inherit;
    }
    .leaflet-container {
        font-family: inherit;
    }
</style>
@endpush

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">
    <div class="mb-7">
        <h2 class="text-2xl font-semibold tracking-tight mb-2">Peta Sebaran Kasus</h2>
        <p class="text-gray-500 text-sm">Visualisasi lokasi kasus kesehatan di Indonesia</p>
    </div>
    <div id="mapKasus"></div>
    <div class="flex items-center gap-6 mt-6 text-sm text-gray-600">
        <div class="flex items-center gap-2">
            <span class="inline-block h-3 w-3 rounded-full bg-red-500"></span>
            Tinggi
        </div>
        <div class="flex items-center gap-2">
            <span class="inline-block h-3 w-3 rounded-full bg-yellow-400"></span>
            Sedang
        </div>
        <div class="flex items-center gap-2">
            <span class="inline-block h-3 w-3 rounded-full bg-green-500"></span>
            Rendah
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    // Inisialisasi Map
    const map = L.map('mapKasus').setView([-2.5489, 118.0149], 5);

    // Tile layer light
    L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors &copy; <a href="https://carto.com/attributions">CARTO</a>',
        subdomains: 'abcd',
        maxZoom: 19
    }).addTo(map);

    // Custom Icon Generator
    function markerIcon(color) {
        return L.divIcon({
            className: 'custom-marker',
            html: `
                <svg width="28" height="28" viewBox="0 0 32 32">
                    <circle cx="16" cy="16" r="12" fill="${color}" stroke="#fff" stroke-width="2"/>
                </svg>
            `,
            iconSize: [32, 32],
            iconAnchor: [16, 16],
            popupAnchor: [0, -16]
        });
    }

    // Data Marker Dummy (Ganti dengan data dinamis jika ada)
    const locations = [
        { name: 'RS Jakarta', coords: [-6.2088, 106.8456], kasus: 110, level: 'tinggi', color: '#ef4444' },
        { name: 'RS Bandung', coords: [-6.9175, 107.6191], kasus: 75, level: 'sedang', color: '#f59e0b' },
        { name: 'RS Surabaya', coords: [-7.2575, 112.7521], kasus: 40, level: 'rendah', color: '#10b981' }
    ];

    locations.forEach(l => {
        const m = L.marker(l.coords, { icon: markerIcon(l.color) }).addTo(map);
        m.bindPopup(`
            <div class="font-sans" style="min-width:150px;">
                <strong>${l.name}</strong>
                <div class="flex items-center mb-1">
                    <span class="inline-block h-2 w-2 rounded-full mr-2" style="background:${l.color}"></span>
                    <span class="capitalize text-xs">${l.level}</span>
                </div>
                <div class="text-xs text-gray-700">Jumlah kasus: <span class="font-semibold">${l.kasus}</span></div>
            </div>
        `);
    });

    // Responsive map fix if needed
    setTimeout(() => { map.invalidateSize(); }, 300);
});
</script>
@endpush
