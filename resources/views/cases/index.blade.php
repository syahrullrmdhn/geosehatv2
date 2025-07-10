@extends('layouts.app')
@section('title','Data Kasus')
@section('content')
<div class="flex flex-col gap-6">
    <div class="flex flex-col md:flex-row justify-between items-center mb-6 px-0 py-0">
        <h2 class="text-2xl font-semibold tracking-tight">Data Kasus</h2>
        <a href="{{ route('cases.create') }}"
           class="mt-3 md:mt-0 px-5 py-2 border border-gray-300 rounded-lg text-gray-700 font-medium text-sm transition hover:bg-gray-50 focus:outline-none">
            Tambah Kasus
        </a>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-200 rounded-lg text-sm">
            <thead>
                <tr class="border-b border-gray-200">
                    <th class="px-4 py-3 font-medium text-left">No</th>
                    <th class="px-4 py-3 font-medium text-left">Judul Kasus</th>
                    <th class="px-4 py-3 font-medium text-left">Tanggal</th>
                    <th class="px-4 py-3 font-medium text-left">Status</th>
                    <th class="px-4 py-3 font-medium text-left">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($records as $record)
                <tr class="border-b last:border-0">
                    <td class="px-4 py-2 align-top">{{ $loop->iteration }}</td>
                    <td class="px-4 py-2 align-top">{{ $record->judul }}</td>
                    <td class="px-4 py-2 align-top">{{ $record->tanggal->format('d M Y') }}</td>
                    <td class="px-4 py-2 align-top">{{ $record->status }}</td>
                    <td class="px-4 py-2 flex gap-2 align-top">
                        <a href="{{ route('cases.show', $record) }}"
                           class="px-3 py-1 border border-gray-300 rounded text-xs text-gray-700 hover:bg-gray-50 transition">Detail</a>
                        <a href="{{ route('cases.edit', $record) }}"
                           class="px-3 py-1 border border-gray-300 rounded text-xs text-gray-700 hover:bg-gray-50 transition">Edit</a>
                        <form action="{{ route('cases.destroy', $record) }}" method="POST" onsubmit="return confirm('Yakin hapus data?')" class="inline">
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
                    <td colspan="5" class="py-6 text-center text-gray-400">Belum ada data kasus.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4 flex justify-end">
        {{ $records->links() }}
    </div>
</div>
@endsection
