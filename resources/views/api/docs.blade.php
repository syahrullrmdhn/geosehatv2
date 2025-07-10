@extends('layouts.app')
@section('title','API Documentation')

@section('content')
<div class="w-full max-w-5xl mx-auto py-6">
    <h2 class="text-2xl font-semibold mb-4">API Documentation</h2>
    <div class="bg-white border border-gray-200 rounded-lg p-6 space-y-7">

        {{-- Intro --}}
        <div>
            <h3 class="text-lg font-semibold mb-2">Introduction</h3>
            <p class="text-gray-600 text-sm">
                Berikut adalah dokumentasi endpoint utama API. Semua permintaan dan respons menggunakan format <strong>JSON</strong>.
            </p>
        </div>

        {{-- Authentication --}}
        <div>
            <h3 class="text-lg font-semibold mb-2">Authentication</h3>
            <p class="text-gray-600 text-sm mb-1">
                Gunakan header <code class="bg-gray-100 px-2 rounded text-xs">Authorization: Bearer &lt;token&gt;</code> untuk akses endpoint yang membutuhkan autentikasi.
            </p>
        </div>

        {{-- Endpoint List --}}
        <div>
            <h3 class="text-lg font-semibold mb-2">Endpoints</h3>
            <div class="space-y-5">

                {{-- Example 1: Get All Cases --}}
                <div>
                    <div class="flex items-center gap-2 mb-1">
                        <span class="inline-block text-xs font-bold bg-gray-200 px-2 py-0.5 rounded">GET</span>
                        <span class="font-mono text-sm text-gray-700">/api/cases</span>
                    </div>
                    <p class="text-gray-500 text-sm mb-2">Ambil daftar semua kasus.</p>
                    <pre class="bg-gray-50 rounded px-4 py-3 text-xs text-gray-800 mb-1">
Response:
[
  {
    "id": 1,
    "region": "Jakarta",
    "disease": "DBD",
    "count": 110,
    "date": "2024-07-10"
  },
  ...
]
                    </pre>
                </div>

                {{-- Example 2: Get Single Case --}}
                <div>
                    <div class="flex items-center gap-2 mb-1">
                        <span class="inline-block text-xs font-bold bg-gray-200 px-2 py-0.5 rounded">GET</span>
                        <span class="font-mono text-sm text-gray-700">/api/cases/{id}</span>
                    </div>
                    <p class="text-gray-500 text-sm mb-2">Ambil detail kasus berdasarkan ID.</p>
                    <pre class="bg-gray-50 rounded px-4 py-3 text-xs text-gray-800 mb-1">
Response:
{
  "id": 1,
  "region": "Jakarta",
  "disease": "DBD",
  "count": 110,
  "date": "2024-07-10"
}
                    </pre>
                </div>

                {{-- Example 3: Create Case --}}
                <div>
                    <div class="flex items-center gap-2 mb-1">
                        <span class="inline-block text-xs font-bold bg-gray-200 px-2 py-0.5 rounded">POST</span>
                        <span class="font-mono text-sm text-gray-700">/api/cases</span>
                    </div>
                    <p class="text-gray-500 text-sm mb-2">Tambah kasus baru. <b>Authentication required</b>.</p>
                    <pre class="bg-gray-50 rounded px-4 py-3 text-xs text-gray-800 mb-1">
Request:
{
  "region_id": 2,
  "disease_id": 1,
  "count": 45,
  "date": "2024-07-10"
}

Response:
{
  "success": true,
  "data": { ... }
}
                    </pre>
                </div>

                {{-- Example 4: Update Case --}}
                <div>
                    <div class="flex items-center gap-2 mb-1">
                        <span class="inline-block text-xs font-bold bg-gray-200 px-2 py-0.5 rounded">PUT</span>
                        <span class="font-mono text-sm text-gray-700">/api/cases/{id}</span>
                    </div>
                    <p class="text-gray-500 text-sm mb-2">Update kasus berdasarkan ID. <b>Authentication required</b>.</p>
                    <pre class="bg-gray-50 rounded px-4 py-3 text-xs text-gray-800 mb-1">
Request:
{
  "count": 55
}

Response:
{
  "success": true,
  "data": { ... }
}
                    </pre>
                </div>

                {{-- Example 5: Delete Case --}}
                <div>
                    <div class="flex items-center gap-2 mb-1">
                        <span class="inline-block text-xs font-bold bg-gray-200 px-2 py-0.5 rounded">DELETE</span>
                        <span class="font-mono text-sm text-gray-700">/api/cases/{id}</span>
                    </div>
                    <p class="text-gray-500 text-sm mb-2">Hapus kasus. <b>Authentication required</b>.</p>
                    <pre class="bg-gray-50 rounded px-4 py-3 text-xs text-gray-800 mb-1">
Response:
{
  "success": true
}
                    </pre>
                </div>
            </div>
        </div>

        {{-- Footer --}}
        <div>
            <hr class="my-6 border-gray-100">
            <div class="text-xs text-gray-400">
                &copy; {{ now()->year }} Health API Documentation
            </div>
        </div>
    </div>
</div>
@endsection
