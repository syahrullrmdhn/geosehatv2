@extends('layouts.app')
@section('title','Edit Wilayah')

@section('content')
<div class="w-full max-w-xl mx-auto py-6">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-semibold">Edit Wilayah</h2>
        <a href="{{ route('regions.index') }}"
           class="px-4 py-2 border border-gray-300 rounded hover:bg-gray-50 text-sm">
            &larr; Kembali
        </a>
    </div>

    @if ($errors->any())
        <div class="mb-4 p-4 bg-red-50 border border-red-200 text-red-700 rounded">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li class="text-sm">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('regions.update', $region) }}" method="POST"
          class="bg-white p-6 border border-gray-200 rounded-lg">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-gray-700">
                Nama Wilayah<span class="text-red-500">*</span>
            </label>
            <input type="text" name="name" id="name"
                   value="{{ old('name', $region->name) }}"
                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200 focus:border-indigo-500"
                   required>
        </div>

        <div class="mb-6">
            <label for="description" class="block text-sm font-medium text-gray-700">
                Deskripsi
            </label>
            <textarea name="description" id="description" rows="4"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200 focus:border-indigo-500">{{ old('description', $region->description) }}</textarea>
        </div>

        <div class="flex items-center gap-4">
            <button type="submit"
                    class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 transition">
                Update
            </button>
            <a href="{{ route('regions.index') }}"
               class="px-4 py-2 border border-gray-300 rounded hover:bg-gray-50">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection
