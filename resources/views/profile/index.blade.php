@extends('layouts.app')
@section('title','Profil Anda')

@section('content')
<div class="max-w-xl mx-auto py-8">
    <h2 class="text-2xl font-semibold mb-6">Profil Anda</h2>
    <div class="bg-white border rounded-lg p-6 shadow-sm space-y-5">

        <form method="POST" action="{{ route('profile.update') }}">
            @csrf
            @method('PATCH')

            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Nama</label>
                <input id="name" type="text" name="name" value="{{ old('name', auth()->user()->name) }}"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                    required autofocus autocomplete="name">
                @error('name')
                  <span class="text-xs text-red-600">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email', auth()->user()->email) }}"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                    required autocomplete="email">
                @error('email')
                  <span class="text-xs text-red-600">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-6">
                <label for="password" class="block text-sm font-medium text-gray-700">Kata Sandi Baru (opsional)</label>
                <input id="password" type="password" name="password"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                    autocomplete="new-password">
                @error('password')
                  <span class="text-xs text-red-600">{{ $message }}</span>
                @enderror
            </div>

            <div class="flex items-center gap-3">
                <button type="submit"
                    class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white font-semibold rounded hover:bg-indigo-700">
                    Simpan Perubahan
                </button>
                <a href="{{ route('dashboard') }}" class="text-sm text-gray-500 hover:underline">Batal</a>
            </div>
        </form>

        {{-- Hapus akun --}}
        <form method="POST" action="{{ route('profile.destroy') }}" class="mt-4">
            @csrf
            @method('DELETE')
            <button type="submit" onclick="return confirm('Yakin ingin menghapus akun Anda? Semua data Anda akan hilang!')"
                class="px-4 py-2 bg-red-600 text-white text-sm rounded hover:bg-red-700">
                Hapus Akun
            </button>
        </form>
    </div>
</div>
@endsection
