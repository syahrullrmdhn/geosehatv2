@extends('layouts.app')
@section('title','PWA Settings')

@section('content')
<div class="w-full max-w-3xl mx-auto py-6">
    <h2 class="text-2xl font-semibold mb-4">PWA Settings</h2>
    <div class="bg-white border border-gray-200 rounded-lg p-6 space-y-6">
        {{-- Manifest.json config --}}
        <div>
            <h3 class="text-base font-semibold mb-2">Manifest.json</h3>
            <pre class="bg-gray-50 border border-gray-100 rounded p-4 text-xs text-gray-800 overflow-x-auto mb-1">
{
  "name": "Health Monitoring App",
  "short_name": "HealthApp",
  "start_url": "/",
  "display": "standalone",
  "background_color": "#ffffff",
  "theme_color": "#2563eb",
  "icons": [
    {
      "src": "/icons/icon-192x192.png",
      "sizes": "192x192",
      "type": "image/png"
    }
  ]
}
            </pre>
            <p class="text-gray-500 text-xs">Ubah sesuai kebutuhan branding aplikasi Anda.</p>
        </div>

        {{-- Service Worker config --}}
        <div>
            <h3 class="text-base font-semibold mb-2">Service Worker (sw.js)</h3>
            <pre class="bg-gray-50 border border-gray-100 rounded p-4 text-xs text-gray-800 overflow-x-auto mb-1">
// sw.js - Contoh sangat sederhana
self.addEventListener('install', event => {
    self.skipWaiting();
});

self.addEventListener('fetch', event => {
    event.respondWith(
        caches.match(event.request)
            .then(response => response || fetch(event.request))
    );
});
            </pre>
            <p class="text-gray-500 text-xs">Tambahkan cache dan logika offline sesuai kebutuhan.</p>
        </div>
    </div>
</div>
@endsection
