@extends('layouts.app')
@section('title','Scheduled Reports')

@section('content')
<div class="w-full max-w-3xl mx-auto py-6">
    <h2 class="text-2xl font-semibold mb-4">Scheduled Reports</h2>
    <div class="bg-white border border-gray-200 rounded-lg p-6">
        {{-- Tabel jadwal report otomatis / cron --}}
        <table class="min-w-full table-auto">
            <thead>
                <tr class="border-b border-gray-100">
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">No</th>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Nama Report</th>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Jadwal</th>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Status</th>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Aksi</th>
                </tr>
            </thead>
            <tbody>
                {{-- Contoh dummy, ganti dengan loop data real --}}
                <tr>
                    <td class="px-4 py-3">1</td>
                    <td class="px-4 py-3">Weekly Recap</td>
                    <td class="px-4 py-3">Setiap Senin, 07:00 WIB</td>
                    <td class="px-4 py-3">Aktif</td>
                    <td class="px-4 py-3">
                        <button class="px-3 py-1 border border-gray-300 rounded text-xs text-gray-700 hover:bg-gray-50 transition">Nonaktifkan</button>
                    </td>
                </tr>
                <tr>
                    <td class="px-4 py-3">2</td>
                    <td class="px-4 py-3">Monthly Report</td>
                    <td class="px-4 py-3">Tanggal 1, 08:00 WIB</td>
                    <td class="px-4 py-3">Aktif</td>
                    <td class="px-4 py-3">
                        <button class="px-3 py-1 border border-gray-300 rounded text-xs text-gray-700 hover:bg-gray-50 transition">Nonaktifkan</button>
                    </td>
                </tr>
                <tr>
                    <td class="px-4 py-3 text-gray-400" colspan="5" align="center">Data jadwal lain akan muncul di sini…</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection
