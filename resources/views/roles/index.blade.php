@extends('layouts.app')
@section('title','Role & Permission')
@section('content')
<div class="max-w-3xl mx-auto py-8">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-bold">Role & Permission</h2>
        <a href="{{ route('roles.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-sm font-semibold shadow-sm">
            Tambah Role
        </a>
    </div>

    @if(session('success'))
        <div class="mb-4 bg-green-100 text-green-700 rounded px-4 py-3">{{ session('success') }}</div>
    @endif

    @php
        use Spatie\Permission\Models\Role;
    @endphp

    @foreach(Role::all() as $role)
    <div class="mb-6 bg-white shadow rounded-lg p-5">
        <div class="flex items-center justify-between mb-2">
            <div>
                <div class="font-bold text-lg text-gray-800">{{ $role->name }}</div>
                <div class="text-xs text-gray-400">#{{ $role->id }}</div>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('roles.edit', $role->id) }}" class="text-indigo-600 hover:underline text-sm">Edit</a>
                <form method="POST" action="{{ route('roles.destroy', $role->id) }}" onsubmit="return confirm('Hapus role ini?')" class="inline">
                    @csrf @method('DELETE')
                    <button type="submit" class="text-red-600 hover:underline text-sm">Hapus</button>
                </form>
            </div>
        </div>
        <div class="mt-3">
            <div class="text-gray-600 text-sm font-semibold mb-1">Permissions:</div>
            <div class="flex flex-wrap gap-2">
                @forelse($role->permissions as $permission)
                    <span class="px-2 py-1 rounded bg-gray-100 text-gray-700 text-xs font-medium">{{ $permission->name }}</span>
                @empty
                    <span class="text-gray-400 italic text-xs">No permissions</span>
                @endforelse
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection
