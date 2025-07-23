@extends('layouts.app')
@section('title', 'Input Data Kasus')

@push('styles')
  <!-- Leaflet CSS -->
  <link
    rel="stylesheet"
    href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
    integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
    crossorigin=""
  />
  <style>
    #selectMap {
      height: 300px;
      min-height: 200px;
      width: 100%;
      border-radius: 0.5rem;
      border: 1px solid #e5e7eb;
      margin-bottom: 1rem;
    }
  </style>
@endpush

@section('content')
<div class="max-w-2xl mx-auto py-8">
  <h2 class="text-2xl font-semibold mb-6">Input Data Kasus</h2>

  <form action="{{ route('cases.store') }}" method="POST"
        class="space-y-6 bg-white p-6 rounded-lg shadow">
    @csrf

    {{-- Peta untuk pilih lokasi --}}
    <div>
      <label class="block text-sm font-medium text-gray-700 mb-1">Pilih Lokasi Kasus</label>
      <div id="selectMap"></div>
      <div class="flex gap-4 text-sm text-gray-600">
        <div>Lat: <span id="latText">{{ old('latitude','–') }}</span></div>
        <div>Lng: <span id="lngText">{{ old('longitude','–') }}</span></div>
      </div>
      <input type="hidden" name="latitude"  id="latitude"  value="{{ old('latitude') }}">
      <input type="hidden" name="longitude" id="longitude" value="{{ old('longitude') }}">
      @error('latitude')
        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
      @enderror
      @error('longitude')
        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
      @enderror
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
      {{-- Tanggal --}}
      <div>
        <label for="date_reported" class="block text-sm font-medium text-gray-700 mb-1">Tanggal</label>
        <input type="date" name="date_reported" id="date_reported"
               value="{{ old('date_reported') }}"
               class="w-full border-gray-300 rounded-md p-2 focus:ring focus:ring-indigo-200"
               required>
        @error('date_reported')
          <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
        @enderror
      </div>

      {{-- Wilayah --}}
      <div>
        <label for="region_id" class="block text-sm font-medium text-gray-700 mb-1">Wilayah</label>
        <select name="region_id" id="region_id"
                class="w-full border-gray-300 rounded-md p-2 focus:ring focus:ring-indigo-200"
                required>
          <option value="">-- Pilih Wilayah --</option>
          @foreach($regions as $id => $name)
            <option value="{{ $id }}" @selected(old('region_id') == $id)>
              {{ $name }}
            </option>
          @endforeach
        </select>
        @error('region_id')
          <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
        @enderror
      </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
      {{-- Penyakit --}}
      <div>
        <label for="disease_id" class="block text-sm font-medium text-gray-700 mb-1">Penyakit</label>
        <select name="disease_id" id="disease_id"
                class="w-full border-gray-300 rounded-md p-2 focus:ring focus:ring-indigo-200"
                required>
          <option value="">-- Pilih Penyakit --</option>
          @foreach($diseases as $id => $name)
            <option value="{{ $id }}" @selected(old('disease_id') == $id)>
              {{ $name }}
            </option>
          @endforeach
        </select>
        @error('disease_id')
          <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
        @enderror
      </div>

      {{-- Jumlah Kasus --}}
      <div>
        <label for="count" class="block text-sm font-medium text-gray-700 mb-1">Jumlah Kasus</label>
        <input type="number" name="count" id="count" min="0"
               value="{{ old('count') }}"
               class="w-full border-gray-300 rounded-md p-2 focus:ring focus:ring-indigo-200"
               required>
        @error('count')
          <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
        @enderror
      </div>
    </div>

    {{-- Submit --}}
    <div class="text-right">
      <a href="{{ route('cases.index') }}"
         class="px-4 py-2 mr-3 border border-gray-300 rounded hover:bg-gray-50 text-sm">
        Batal
      </a>
      <button type="submit"
              class="px-6 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 transition">
        Simpan
      </button>
    </div>
  </form>
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
      // 1) inisialisasi map
      const map = L.map('selectMap').setView([-2.5489, 118.0149], 5);
      L.tileLayer(
        'https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png',
        {
          attribution:
            '&copy; <a href="https://www.openstreetmap.org/">OSM</a> &copy; CARTO',
          subdomains: 'abcd',
          maxZoom: 19
        }
      ).addTo(map);

      let marker;

      // 2) fungsi update posisi
      function updatePosition(lat, lng) {
        document.getElementById('latitude').value  = lat;
        document.getElementById('longitude').value = lng;
        document.getElementById('latText').textContent = lat.toFixed(6);
        document.getElementById('lngText').textContent = lng.toFixed(6);
      }

      // 3) jika ada old coords (form validation), tampilkan marker
      const oldLat = parseFloat(@json(old('latitude')));
      const oldLng = parseFloat(@json(old('longitude')));
      if (!isNaN(oldLat) && !isNaN(oldLng)) {
        marker = L.marker([oldLat, oldLng], { draggable: true }).addTo(map);
        map.setView([oldLat, oldLng], 13);
        updatePosition(oldLat, oldLng);
        marker.on('dragend', e => {
          const pos = e.target.getLatLng();
          updatePosition(pos.lat, pos.lng);
        });
      }

      // 4) klik di map untuk set/move marker
      map.on('click', e => {
        const { lat, lng } = e.latlng;
        if (marker) {
          marker.setLatLng([lat, lng]);
        } else {
          marker = L.marker([lat, lng], { draggable: true }).addTo(map);
          marker.on('dragend', e2 => {
            const p = e2.target.getLatLng();
            updatePosition(p.lat, p.lng);
          });
        }
        updatePosition(lat, lng);
      });
    });
  </script>
@endpush
