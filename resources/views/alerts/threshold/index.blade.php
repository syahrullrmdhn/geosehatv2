@extends('layouts.app')

@section('title', 'Threshold Alerts')

@section('content')
<div class="w-full max-w-4xl mx-auto py-6">
    <h2 class="text-2xl font-semibold mb-4">Threshold Alerts</h2>
    @if(session('success'))
        <div class="mb-3 p-2 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
    @endif
    <a href="{{ route('alerts.threshold.create') }}" class="mb-4 inline-block px-4 py-2 bg-blue-600 text-white rounded">Tambah Threshold</a>
    <div class="bg-white border border-gray-200 rounded-lg overflow-hidden">
        <table class="min-w-full table-auto">
            <thead>
                <tr class="border-b border-gray-100">
                    <th class="px-4 py-2">Wilayah</th>
                    <th class="px-4 py-2">Penyakit</th>
                    <th class="px-4 py-2">Ambang Kasus</th>
                    <th class="px-4 py-2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($thresholds as $th)
                <tr>
                    <td class="px-4 py-2">{{ $th->region->name ?? '-' }}</td>
                    <td class="px-4 py-2">{{ $th->disease->name ?? '-' }}</td>
                    <td class="px-4 py-2">{{ $th->threshold }}</td>
                    <td class="px-4 py-2">
                        <a href="{{ route('alerts.threshold.edit', $th->id) }}" class="px-3 py-1 border rounded text-xs">Edit</a>
                        <form method="POST" action="{{ route('alerts.threshold.destroy', $th->id) }}" class="inline" onsubmit="return confirm('Yakin hapus?')">
                            @csrf @method('DELETE')
                            <button class="px-3 py-1 border rounded text-xs text-red-600">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="4" class="text-center text-gray-400 py-6">Belum ada data threshold.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
