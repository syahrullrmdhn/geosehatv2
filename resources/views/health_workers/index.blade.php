@extends('layouts.app')
@section('title','Daftar Tenaga Kesehatan')

@section('content')
<div class="max-w-3xl mx-auto py-8">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold">Daftar Tenaga Kesehatan</h2>
        <a href="{{ route('health_workers.create') }}" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">Tambah</a>
    </div>
    @if(session('success'))
        <div class="mb-4 p-3 rounded bg-green-100 text-green-700">{{ session('success') }}</div>
    @endif
    <div class="bg-white shadow rounded-lg overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead>
                <tr class="bg-gray-50 text-gray-600 uppercase">
                    <th class="px-4 py-2 text-left">Nama</th>
                    <th class="px-4 py-2 text-left">Profesi</th>
                    <th class="px-4 py-2 text-left">Wilayah</th>
                    <th class="px-4 py-2 text-left">Telepon</th>
                    <th class="px-4 py-2 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($workers as $w)
                <tr class="border-t hover:bg-gray-50">
                    <td class="px-4 py-2">{{ $w->name }}</td>
                    <td class="px-4 py-2">{{ $w->profession }}</td>
                    <td class="px-4 py-2">{{ $w->region }}</td>
                    <td class="px-4 py-2">{{ $w->phone }}</td>
                    <td class="px-4 py-2 text-center">
                        <a href="{{ route('health_workers.edit', $w->id) }}" class="text-indigo-600 hover:underline">Edit</a>
                        <form method="POST" action="{{ route('health_workers.destroy', $w->id) }}" class="inline" onsubmit="return confirm('Yakin hapus?')">
                            @csrf @method('DELETE')
                            <button class="ml-2 text-red-600 hover:underline">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-4 py-3 text-center text-gray-400">Belum ada data</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <div class="px-4 py-2">{{ $workers->links() }}</div>
    </div>
</div>
@endsection
