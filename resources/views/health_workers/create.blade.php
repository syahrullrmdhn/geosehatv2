@extends('layouts.app')
@section('title','Tambah Tenaga Kesehatan')
@section('content')
<div class="max-w-md mx-auto py-10">
    <h2 class="text-2xl font-bold mb-6">Tambah Tenaga Kesehatan</h2>
    <form method="POST" action="{{ route('health_workers.store') }}" class="space-y-4 bg-white shadow p-6 rounded-lg">
        @csrf
        <div>
            <label>Nama</label>
            <input type="text" name="name" class="w-full border rounded p-2" value="{{ old('name') }}" required>
            @error('name')<div class="text-sm text-red-600">{{ $message }}</div>@enderror
        </div>
        <div>
            <label>Profesi</label>
            <input type="text" name="profession" class="w-full border rounded p-2" value="{{ old('profession') }}" required>
            @error('profession')<div class="text-sm text-red-600">{{ $message }}</div>@enderror
        </div>
        <div>
            <label>Wilayah</label>
            <input type="text" name="region" class="w-full border rounded p-2" value="{{ old('region') }}" required>
            @error('region')<div class="text-sm text-red-600">{{ $message }}</div>@enderror
        </div>
        <div>
            <label>Telepon</label>
            <input type="text" name="phone" class="w-full border rounded p-2" value="{{ old('phone') }}">
            @error('phone')<div class="text-sm text-red-600">{{ $message }}</div>@enderror
        </div>
        <div class="flex gap-3 mt-6">
            <a href="{{ route('health_workers.index') }}" class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">Batal</a>
            <button class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">Simpan</button>
        </div>
    </form>
</div>
@endsection
