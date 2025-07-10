@extends('layouts.app')
@section('title','Backup & Restore')

@section('content')
<div class="max-w-2xl mx-auto py-6 space-y-6">

    <h2 class="text-2xl font-semibold mb-4">Backup & Restore</h2>

    {{-- Tombol Backup Baru --}}
    <div class="bg-white border rounded-lg p-6 flex items-center gap-4 shadow-sm">
        <form action="#" method="POST">
            @csrf
            <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white font-semibold rounded hover:bg-indigo-700">
                <x-heroicon-o-cloud-arrow-up class="h-5 w-5 mr-2"/> Backup Sekarang
            </button>
        </form>
        <span class="text-sm text-gray-500">Terakhir backup: <span class="font-medium">24 Jan 2024 21:17</span></span>
    </div>

    {{-- List File Backup (Dummy) --}}
    <div class="bg-white border rounded-lg shadow-sm">
        <div class="px-6 py-3 border-b">
            <h3 class="font-medium">Daftar File Backup</h3>
        </div>
        <table class="min-w-full divide-y divide-gray-100">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-2 text-left text-xs font-semibold text-gray-500 uppercase">Nama File</th>
                    <th class="px-6 py-2 text-left text-xs font-semibold text-gray-500 uppercase">Tanggal</th>
                    <th class="px-6 py-2"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach([
                    ['file' => 'backup-2024-01-24-211700.zip', 'date' => '24 Jan 2024 21:17'],
                    ['file' => 'backup-2024-01-20-155000.zip', 'date' => '20 Jan 2024 15:50'],
                ] as $backup)
                <tr>
                    <td class="px-6 py-2 font-mono text-sm">{{ $backup['file'] }}</td>
                    <td class="px-6 py-2 text-sm text-gray-600">{{ $backup['date'] }}</td>
                    <td class="px-6 py-2 flex gap-2">
                        <a href="#" class="inline-flex items-center px-2 py-1 text-xs bg-blue-50 text-blue-600 rounded hover:bg-blue-100">
                            <x-heroicon-o-arrow-down-tray class="h-4 w-4 mr-1"/> Download
                        </a>
                        <form action="#" method="POST" onsubmit="return confirm('Yakin hapus backup ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="inline-flex items-center px-2 py-1 text-xs bg-red-50 text-red-600 rounded hover:bg-red-100">
                                <x-heroicon-o-trash class="h-4 w-4 mr-1"/> Hapus
                            </button>
                        </form>
                        <form action="#" method="POST" onsubmit="return confirm('Restore backup ini? Data sekarang akan ditimpa!')">
                            @csrf
                            <button type="submit" class="inline-flex items-center px-2 py-1 text-xs bg-green-50 text-green-600 rounded hover:bg-green-100">
                                <x-heroicon-o-arrow-path class="h-4 w-4 mr-1"/> Restore
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
                {{-- Jika kosong --}}
                @if(false)
                <tr>
                    <td colspan="3" class="px-6 py-8 text-center text-gray-400">Belum ada file backup.</td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
@endsection
