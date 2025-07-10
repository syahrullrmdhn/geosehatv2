@extends('layouts.app')
@section('title','Activity Log')

@section('content')
<div class="w-full max-w-4xl mx-auto py-6">
    <h2 class="text-2xl font-semibold mb-4">Activity Log</h2>
    <div class="bg-white border border-gray-200 rounded-lg overflow-hidden">
        <table class="min-w-full table-auto">
            <thead>
                <tr class="border-b border-gray-100">
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">No</th>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Tanggal</th>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">User</th>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Aktivitas</th>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Deskripsi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($logs as $log)
                <tr class="border-b last:border-0">
                    <td class="px-4 py-3">{{ $loop->iteration }}</td>
                    <td class="px-4 py-3 text-xs text-gray-600">
                        {{ $log->created_at ? $log->created_at->format('d M Y H:i') : '-' }}
                    </td>
                    <td class="px-4 py-3">
                        {{ $log->causer ? ($log->causer->name ?? '-') : '-' }}
                    </td>
                    <td class="px-4 py-3 text-sm">
                        {{ $log->event ?? $log->description }}
                    </td>
                    <td class="px-4 py-3 text-gray-600 text-xs break-all">
                        {{ $log->properties ? json_encode($log->properties) : '-' }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-4 py-6 text-center text-gray-400">Belum ada aktivitas tercatat.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
