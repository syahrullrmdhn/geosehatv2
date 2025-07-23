@extends('layouts.app')
@section('title', 'Edit Threshold')

@section('content')
<div class="max-w-md mx-auto py-8">
    <h2 class="text-2xl font-bold mb-6">Edit Threshold</h2>
    <form method="POST" action="{{ route('alerts.threshold.update', $threshold->id) }}" class="bg-white p-6 rounded shadow space-y-4">
        @csrf @method('PUT')
        <div>
            <label>Wilayah</label>
            <select name="region_id" class="w-full border rounded p-2" required>
                @foreach($regions as $region)
                <option value="{{ $region->id }}" @selected($threshold->region_id == $region->id)>
                    {{ $region->name }}
                </option>
                @endforeach
            </select>
        </div>
        <div>
            <label>Penyakit</label>
            <select name="disease_id" class="w-full border rounded p-2" required>
                @foreach($diseases as $disease)
                <option value="{{ $disease->id }}" @selected($threshold->disease_id == $disease->id)>
                    {{ $disease->name }}
                </option>
                @endforeach
            </select>
        </div>
        <div>
            <label>Ambang Kasus</label>
            <input type="number" name="threshold" class="w-full border rounded p-2"
                value="{{ old('threshold', $threshold->threshold) }}" min="1" required>
        </div>
        <div class="flex gap-2 mt-6">
            <a href="{{ route('alerts.threshold.index') }}" class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">Batal</a>
            <button class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Update</button>
        </div>
    </form>
</div>
@endsection
