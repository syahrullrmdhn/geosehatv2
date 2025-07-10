@extends('layouts.app')
@section('title','Data Privacy')

@section('content')
<div class="max-w-2xl mx-auto py-6 space-y-6">

    <h2 class="text-2xl font-semibold mb-4">Data Privacy</h2>

    <div class="bg-white border rounded-lg p-6 shadow-sm space-y-4">
        <h3 class="text-lg font-semibold">Kebijakan Privasi & Perlindungan Data</h3>
        <p class="text-gray-700">
            Kami menghormati privasi dan keamanan data pengguna sistem GeoSehat. Setiap data pribadi dan rekam kesehatan akan disimpan secara terenkripsi dan tidak dibagikan ke pihak ketiga tanpa persetujuan.
        </p>
        <ul class="list-disc ml-5 text-gray-700 space-y-1">
            <li>Data pengguna hanya digunakan untuk keperluan pemantauan kesehatan dan peningkatan layanan.</li>
            <li>Pengguna dapat mengajukan permintaan penghapusan data mereka sewaktu-waktu melalui fitur di aplikasi ini.</li>
            <li>Kami menerapkan standar keamanan data sesuai dengan prinsip GDPR dan UU Perlindungan Data Pribadi.</li>
            <li>Backup data dilakukan secara berkala dan hanya dapat diakses oleh administrator yang berwenang.</li>
        </ul>
    </div>

    <div class="bg-white border rounded-lg p-6 shadow-sm space-y-4">
        <h3 class="text-lg font-semibold">Penghapusan Akun & Data (GDPR)</h3>
        <p class="text-gray-700">
            Sesuai dengan regulasi <span class="font-semibold">GDPR (General Data Protection Regulation)</span>, Anda berhak:
        </p>
        <ul class="list-disc ml-5 text-gray-700 space-y-1">
            <li>Meminta akses ke seluruh data pribadi Anda yang tersimpan di sistem.</li>
            <li>Meminta penghapusan akun dan seluruh data terkait secara permanen.</li>
            <li>Mengetahui kebijakan penyimpanan dan penggunaan data oleh sistem kami.</li>
        </ul>
        <div class="mt-4">
            <form action="#" method="POST" onsubmit="return confirm('Yakin ingin mengajukan penghapusan data dan akun Anda?')">
                @csrf
                <button type="submit" class="px-4 py-2 bg-red-600 text-white font-semibold rounded hover:bg-red-700">
                    Ajukan Penghapusan Data & Akun
                </button>
            </form>
        </div>
        <p class="text-xs text-gray-400 mt-2">
            Permintaan penghapusan akan diproses maksimal 7 hari kerja dan seluruh data terkait akun Anda akan dihapus secara permanen dari server.
        </p>
    </div>

</div>
@endsection
