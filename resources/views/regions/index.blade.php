@extends('layouts.app')
@section('title','Master Wilayah')

@section('content')
<div class="w-full max-w-3xl mx-auto py-6">
    <h2 class="text-2xl font-semibold mb-4">Master Wilayah</h2>
    <div class="bg-white border border-gray-200 rounded-lg overflow-hidden">
        <table class="min-w-full table-auto">
            <thead>
                <tr class="border-b border-gray-100">
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">No</th>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Nama Wilayah</th>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Deskripsi</th>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse(App\Models\Region::all() as $region)
                <tr class="border-b last:border-0">
                    <td class="px-4 py-3">{{ $loop->iteration }}</td>
                    <td class="px-4 py-3">{{ $region->name }}</td>
                    <td class="px-4 py-3 text-gray-600">{{ $region->description ?? '-' }}</td>
                    <td class="px-4 py-3 flex gap-2">
                        <a href="{{ route('regions.edit', $region) }}"
                           class="px-3 py-1 border border-gray-300 rounded text-xs text-gray-700 hover:bg-gray-50 transition">Edit</a>
                        <form action="{{ route('regions.destroy', $region) }}" method="POST" onsubmit="return confirm('Yakin hapus data?')" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="px-3 py-1 border border-gray-300 rounded text-xs text-gray-700 hover:bg-gray-50 transition">
                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-4 py-6 text-center text-gray-400">Belum ada data wilayah.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
