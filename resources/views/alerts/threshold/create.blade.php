@extends('layouts.app')
@section('title', 'Tambah Threshold')

@section('content')
<div class="max-w-md mx-auto py-8">
    <h2 class="text-2xl font-bold mb-6">Tambah Threshold</h2>
    <form method="POST" action="{{ route('alerts.threshold.store') }}" class="bg-white p-6 rounded shadow space-y-4">
        @csrf
        <div>
            <label>Wilayah</label>
            <select name="region_id" class="w-full border rounded p-2" required>
                <option value="">-- Pilih Wilayah --</option>
                @foreach($regions as $region)
                <option value="{{ $region->id }}">{{ $region->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label>Penyakit</label>
            <select name="disease_id" class="w-full border rounded p-2" required>
                <option value="">-- Pilih Penyakit --</option>
                @foreach($diseases as $disease)
                <option value="{{ $disease->id }}">{{ $disease->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label>Ambang Kasus</label>
            <input type="number" name="threshold" class="w-full border rounded p-2" min="1" required>
        </div>
        <div class="flex gap-2 mt-6">
            <a href="{{ route('alerts.threshold.index') }}" class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">Batal</a>
            <button class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Simpan</button>
        </div>
    </form>
</div>
@endsection
