@extends('layouts.app')
@section('title','Offline Sync')

@section('content')
<div class="w-full max-w-lg mx-auto py-6">
    <h2 class="text-2xl font-semibold mb-4">Offline Sync</h2>
    <div class="bg-white border border-gray-200 rounded-lg p-6 space-y-6">
        {{-- Status cache offline --}}
        <div>
            <h3 class="text-base font-semibold mb-2">Status Sinkronisasi</h3>
            <p class="text-gray-700 text-sm mb-1">
                <span class="font-medium">Status:</span>
                <span id="offline-status" class="text-gray-900">Mengecek...</span>
            </p>
            <p class="text-gray-500 text-xs">
                Data yang tersimpan offline akan otomatis disinkronkan saat koneksi internet tersedia.
            </p>
        </div>

        {{-- Tombol Sync Manual --}}
        <div>
            <button type="button"
                class="px-5 py-2 border border-gray-300 rounded-md text-gray-700 font-medium text-sm hover:bg-gray-50 transition"
                id="sync-btn">
                Sinkronkan Sekarang
            </button>
            <span id="sync-info" class="ml-2 text-xs text-gray-400"></span>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Dummy: cek koneksi dan status sinkronisasi offline
    function updateStatus() {
        let statusEl = document.getElementById('offline-status');
        if (navigator.onLine) {
            statusEl.textContent = 'Online - Semua data telah sinkron';
        } else {
            statusEl.textContent = 'Offline - Menunggu koneksi untuk sinkronisasi';
        }
    }
    updateStatus();
    window.addEventListener('online', updateStatus);
    window.addEventListener('offline', updateStatus);

    // Dummy: klik sinkronisasi manual
    document.getElementById('sync-btn').onclick = function() {
        document.getElementById('sync-info').textContent = 'Sinkronisasi berjalan...';
        setTimeout(function() {
            document.getElementById('sync-info').textContent = 'Data offline telah tersinkron!';
            updateStatus();
        }, 1200);
    }
});
</script>
@endpush
