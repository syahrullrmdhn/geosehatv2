@extends('layouts.app')
@section('title','Scheduled Reports')

@section('content')
<div class="max-w-3xl mx-auto py-6">
  <h2 class="text-2xl font-semibold mb-4">Scheduled Reports</h2>
  <p class="text-gray-600 mb-6">
    Daftar laporan terjadwal. MySQL Event Scheduler sudah menulis CSV ke server.
    Klik “Download” untuk mengunduh hasil terakhir.
  </p>
  <div class="bg-white border border-gray-200 rounded-lg p-4 overflow-x-auto">
    <table class="min-w-full table-auto">
      <thead>
        <tr class="border-b border-gray-100">
          <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">No</th>
          <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Nama Report</th>
          <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Cron</th>
          <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Status</th>
          <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Terakhir Dijalankan</th>
          <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse($reports as $rep)
        <tr class="border-b last:border-0 hover:bg-gray-50">
          <td class="px-4 py-3">{{ $loop->iteration }}</td>
          <td class="px-4 py-3">{{ $rep->name }}</td>
          <td class="px-4 py-3 font-mono text-xs">{{ $rep->cron_expression }}</td>
          <td class="px-4 py-3 capitalize">{{ $rep->status }}</td>
          <td class="px-4 py-3">
            {{ $rep->last_run_at ? \Carbon\Carbon::parse($rep->last_run_at)->format('d M Y H:i') : '-' }}
          </td>
          <td class="px-4 py-3">
            @if($rep->file_path)
              <a href="{{ route('reports.download', $rep->id) }}"
                 class="inline-block px-3 py-1 bg-green-600 text-white text-xs rounded hover:bg-green-700">
                Download
              </a>
            @else
              <span class="text-gray-400 text-xs">–</span>
            @endif
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="6" class="py-6 text-center text-gray-400">
            Belum ada laporan terjadwal.
          </td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
@endsection
