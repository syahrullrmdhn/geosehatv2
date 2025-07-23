@extends('layouts.app')
@section('title','Edit Tenaga Kesehatan')
@section('content')
<div class="max-w-md mx-auto py-10">
    <h2 class="text-2xl font-bold mb-6">Edit Tenaga Kesehatan</h2>
    <form method="POST" action="{{ route('health_workers.update', $health_worker) }}" class="space-y-4 bg-white shadow p-6 rounded-lg">
        @csrf
        @method('PUT')

        <div>
            <label>Nama</label>
            <input type="text" name="name" class="w-full border rounded p-2" value="{{ old('name', $health_worker->name) }}" required>
            @error('name')<div class="text-sm text-red-600">{{ $message }}</div>@enderror
        </div>

        <div>
            <label>Profesi</label>
            <input type="text" name="profession" class="w-full border rounded p-2" value="{{ old('profession', $health_worker->profession) }}" required>
            @error('profession')<div class="text-sm text-red-600">{{ $message }}</div>@enderror
        </div>

        <div>
            <label>Wilayah</label>
            <select name="region_id" class="w-full border rounded p-2" required>
                <option value="">-- Pilih Wilayah --</option>
                @foreach($regions as $reg)
                    <option value="{{ $reg->id }}"
                        {{ old('region_id', $health_worker->region_id) == $reg->id ? 'selected' : '' }}>
                        {{ $reg->name }}
                    </option>
                @endforeach
            </select>
            @error('region_id')<div class="text-sm text-red-600">{{ $message }}</div>@enderror
        </div>

        <div>
            <label>Telepon</label>
            <input type="text" name="phone" class="w-full border rounded p-2" value="{{ old('phone', $health_worker->phone) }}">
            @error('phone')<div class="text-sm text-red-600">{{ $message }}</div>@enderror
        </div>

        <div class="flex gap-3 mt-6">
            <a href="{{ route('health_workers.index') }}" class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">Batal</a>
            <button class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">Update</button>
        </div>
    </form>
</div>
@endsection
