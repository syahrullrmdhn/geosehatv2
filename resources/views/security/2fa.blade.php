@extends('layouts.app')
@section('title','Two-Factor Authentication')

@section('content')
<div class="w-full max-w-lg mx-auto py-6">
    <h2 class="text-2xl font-semibold mb-4">Two-Factor Authentication</h2>
    <div class="bg-white border border-gray-200 rounded-lg p-6">
        {{-- Placeholder status & aksi --}}
        <div class="mb-5">
            <p class="text-gray-700 mb-1">Status: 
                <span class="font-medium text-gray-900">
                    {{-- Ganti sesuai logic 2FA --}}
                    Tidak Aktif
                </span>
            </p>
            <p class="text-gray-500 text-sm">Two-Factor Authentication menambah keamanan akun Anda dengan meminta kode OTP setiap login.</p>
        </div>
        <form>
            {{-- Jika belum aktif --}}
            <button type="button"
                class="px-5 py-2 border border-gray-300 rounded-md text-gray-700 font-medium text-sm hover:bg-gray-50 transition">
                Aktifkan 2FA
            </button>

            {{-- Jika sudah aktif, tampilkan tombol disable & (optional) QR code --}}
            {{-- 
            <div class="mb-4">
                <img src="URL_QR_CODE" alt="Scan QR" class="h-32 w-32 mx-auto mb-2 rounded">
                <p class="text-xs text-center text-gray-500">Scan kode ini di aplikasi autentikator Anda.</p>
            </div>
            <button type="button"
                class="px-5 py-2 border border-gray-300 rounded-md text-gray-700 font-medium text-sm hover:bg-gray-50 transition">
                Nonaktifkan 2FA
            </button>
            --}}
        </form>
    </div>
</div>
@endsection
