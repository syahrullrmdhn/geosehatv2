@extends('layouts.app')
@section('title','Edit Data Kasus')

@section('content')
<div class="max-w-2xl mx-auto py-8">
  <h2 class="text-2xl font-semibold mb-6">Edit Data Kasus</h2>

  <form action="{{ route('cases.update', $case) }}" method="POST" class="bg-white p-6 rounded-lg shadow space-y-6">
    @csrf @method('PUT')

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
      {{-- Tanggal --}}
      <div>
        <label class="block text-sm font-medium mb-1">Tanggal</label>
        <input type="date" name="date_reported" value="{{ old('date_reported', $case->date_reported) }}"
               class="w-full border-gray-300 rounded-md px-3 py-2 focus:ring focus:ring-indigo-200">
        @error('date_reported')
          <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
        @enderror
      </div>

      {{-- Wilayah --}}
      <div>
        <label class="block text-sm font-medium mb-1">Wilayah</label>
        <select name="region_id"
                class="w-full border-gray-300 rounded-md px-3 py-2 focus:ring focus:ring-indigo-200">
          <option value="">-- Pilih Wilayah --</option>
          @foreach($regions as $id => $name)
            <option value="{{ $id }}"
              @selected(old('region_id', $case->region_id) == $id)>
              {{ $name }}
            </option>
          @endforeach
        </select>
        @error('region_id')
          <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
        @enderror
      </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
      {{-- Penyakit --}}
      <div>
        <label class="block text-sm font-medium mb-1">Penyakit</label>
        <select name="disease_id"
                class="w-full border-gray-300 rounded-md px-3 py-2 focus:ring focus:ring-indigo-200">
          <option value="">-- Pilih Penyakit --</option>
          @foreach($diseases as $id => $name)
            <option value="{{ $id }}"
              @selected(old('disease_id', $case->disease_id) == $id)>
              {{ $name }}
            </option>
          @endforeach
        </select>
        @error('disease_id')
          <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
        @enderror
      </div>

      {{-- Jumlah --}}
      <div>
        <label class="block text-sm font-medium mb-1">Jumlah Kasus</label>
        <input type="number" name="count" min="0" value="{{ old('count', $case->count) }}"
               class="w-full border-gray-300 rounded-md px-3 py-2 focus:ring focus:ring-indigo-200">
        @error('count')
          <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
        @enderror
      </div>
    </div>

    <div class="text-right">
      <a href="{{ route('cases.index') }}"
         class="mr-3 text-gray-600 hover:underline">Batal</a>
      <button type="submit"
              class="px-6 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
        Update
      </button>
    </div>
  </form>
</div>
@endsection
