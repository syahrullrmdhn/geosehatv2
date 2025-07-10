@extends('layouts.app')

@section('title', 'Input Data Kasus')

@section('content')
<div class="w-full max-w-2xl mx-auto space-y-8">

  {{-- Header --}}
  <header class="flex items-center justify-between mb-2">
    <h2 class="text-2xl font-semibold tracking-tight">Input Data Kasus</h2>
    <a href="{{ route('cases.index') }}" class="inline-flex items-center gap-1 text-gray-600 hover:underline text-sm">
      <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
      </svg>
      Kembali ke Daftar
    </a>
  </header>

  {{-- Card Form --}}
  <div class="bg-white border border-gray-200 rounded-lg">
    <form action="{{ route('cases.store') }}" method="POST" class="px-8 py-6 space-y-8">
      @csrf

      <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
        {{-- Tanggal --}}
        <div>
          <label for="date" class="block text-sm font-medium text-gray-800 mb-1">Tanggal</label>
          <input id="date" type="date" name="date" value="{{ old('date') }}"
                 class="block w-full border border-gray-300 rounded-md px-3 py-2 focus:border-gray-500 focus:ring-1 focus:ring-gray-400 transition" />
          @error('date')
            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
          @enderror
        </div>

        {{-- Wilayah --}}
        <div>
          <label for="region_id" class="block text-sm font-medium text-gray-800 mb-1">Wilayah</label>
          <select id="region_id" name="region_id"
                  class="block w-full border border-gray-300 rounded-md px-3 py-2 focus:border-gray-500 focus:ring-1 focus:ring-gray-400 transition">
            <option value="">-- Pilih Wilayah --</option>
            @foreach($regions as $region)
              <option value="{{ $region->id }}" @selected(old('region_id') == $region->id)>
                {{ $region->name }}
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
          <label for="disease_id" class="block text-sm font-medium text-gray-800 mb-1">Penyakit</label>
          <select id="disease_id" name="disease_id"
                  class="block w-full border border-gray-300 rounded-md px-3 py-2 focus:border-gray-500 focus:ring-1 focus:ring-gray-400 transition">
            <option value="">-- Pilih Penyakit --</option>
            @foreach($diseases as $disease)
              <option value="{{ $disease->id }}" @selected(old('disease_id') == $disease->id)>
                {{ $disease->name }}
              </option>
            @endforeach
          </select>
          @error('disease_id')
            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
          @enderror
        </div>

        {{-- Jumlah Kasus --}}
        <div>
          <label for="count" class="block text-sm font-medium text-gray-800 mb-1">Jumlah Kasus</label>
          <input id="count" type="number" name="count" value="{{ old('count') }}" min="0"
                 class="block w-full border border-gray-300 rounded-md px-3 py-2 focus:border-gray-500 focus:ring-1 focus:ring-gray-400 transition" />
          @error('count')
            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
          @enderror
        </div>
      </div>

      {{-- Submit --}}
      <div class="text-right">
        <button type="submit"
                class="inline-flex items-center px-6 py-2 border border-gray-300 rounded-md text-gray-800 font-medium text-sm hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-400 transition">
          Simpan
        </button>
      </div>
    </form>
  </div>
</div>
@endsection
