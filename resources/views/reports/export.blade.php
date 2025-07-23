@extends('layouts.app')
@section('title','Export Data')

@section('content')
<div class="max-w-md mx-auto py-6">
  <h2 class="text-2xl font-semibold mb-4">Export Data Kasus</h2>
  <p class="text-gray-600 mb-6">
    Klik tombol di bawah untuk mengunduh seluruh data kasus dalam format CSV.
    MySQL akan menjalankan raw SQL <code>INTO OUTFILE</code> secara langsung.
  </p>
  <a href="{{ route('reports.export') }}"
     class="inline-block bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition">
    Download CSV
  </a>
</div>
@endsection
