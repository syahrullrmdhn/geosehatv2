@extends('layouts.app')

@section('title', 'Threshold Alerts')

@section('content')
<div class="w-full max-w-4xl mx-auto py-6">
    {{-- Judul + Deskripsi --}}
    <div class="mb-6">
        <h2 class="text-2xl font-semibold">Threshold Alerts</h2>
        <p class="mt-1 text-sm text-gray-600">
            Atur ambang notifikasi berdasarkan kasus per wilayah.
        </p>
    </div>

    {{-- Card Form/Tabel --}}
    <div class="bg-white border border-gray-200 rounded-lg overflow-hidden">
        <form>
            <table class="min-w-full table-auto">
                <thead>
                    <tr class="border-b border-gray-100">
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Wilayah</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Ambang Kasus</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- Contoh dummy, ganti dengan loop data real --}}
                    <tr>
                        <td class="px-4 py-3">Jakarta</td>
                        <td class="px-4 py-3">
                            <input type="number" min="1" value="100"
                                   class="w-24 border border-gray-300 rounded px-2 py-1 text-sm focus:border-gray-500 focus:ring-1 focus:ring-gray-400 transition" />
                        </td>
                        <td class="px-4 py-3">
                            <button type="button" class="px-3 py-1 border border-gray-300 rounded text-xs text-gray-700 hover:bg-gray-50 transition">
                                Reset
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td class="px-4 py-3">Bandung</td>
                        <td class="px-4 py-3">
                            <input type="number" min="1" value="80"
                                   class="w-24 border border-gray-300 rounded px-2 py-1 text-sm focus:border-gray-500 focus:ring-1 focus:ring-gray-400 transition" />
                        </td>
                        <td class="px-4 py-3">
                            <button type="button" class="px-3 py-1 border border-gray-300 rounded text-xs text-gray-700 hover:bg-gray-50 transition">
                                Reset
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td class="px-4 py-3 text-gray-400" colspan="3" align="center">
                            Data wilayah lain akan muncul di sini…
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="px-6 py-4 flex justify-end">
                <button type="submit"
                        class="px-5 py-2 border border-gray-300 rounded-md text-gray-700 font-medium text-sm hover:bg-gray-50 transition">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
