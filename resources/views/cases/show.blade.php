@extends('layouts.app')
@section('title','Detail Kasus')

@section('content')
<div class="max-w-2xl mx-auto py-8 space-y-6">
  <div class="flex justify-between items-center">
    <h2 class="text-2xl font-semibold">Detail Kasus</h2>
    <a href="{{ route('cases.index') }}"
       class="text-gray-600 hover:underline">‹ Kembali</a>
  </div>

  <div class="bg-white p-6 rounded-lg shadow space-y-4">
    <div>
      <span class="font-medium">Tanggal:</span>
      {{ \Carbon\Carbon::parse($case->date_reported)->format('d M Y') }}
    </div>
    <div>
      <span class="font-medium">Wilayah:</span>
      {{ $case->region->name }}
    </div>
    <div>
      <span class="font-medium">Penyakit:</span>
      {{ $case->disease->name }}
    </div>
    <div>
      <span class="font-medium">Jumlah Kasus:</span>
      {{ $case->count }}
    </div>
  </div>

  <div class="flex gap-3">
    <a href="{{ route('cases.edit', $case) }}"
       class="px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600">
      Edit
    </a>
    <form action="{{ route('cases.destroy', $case) }}" method="POST"
          onsubmit="return confirm('Yakin hapus data?')">
      @csrf @method('DELETE')
      <button type="submit"
              class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
        Hapus
      </button>
    </form>
  </div>
</div>
@endsection
