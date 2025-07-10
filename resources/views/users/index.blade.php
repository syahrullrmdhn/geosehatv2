@extends('layouts.app')

@section('title', 'Daftar Users')

@section('content')
<div class="space-y-6">
  <header class="flex items-center justify-between">
    <h2 class="text-2xl font-semibold text-gray-900">Daftar Users</h2>
    <a href="{{ route('users.create') }}"
       class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
      Tambah User
    </a>
  </header>

  <div class="overflow-x-auto bg-white rounded-lg shadow">
    <table class="min-w-full divide-y divide-gray-200">
      <thead class="bg-gray-50">
        <tr>
          <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
          <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
          <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
          <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-gray-100 bg-white">
        @foreach ($users as $user)
          <tr class="hover:bg-gray-50">
            <td class="px-4 py-2 whitespace-nowrap">{{ $user->id }}</td>
            <td class="px-4 py-2 whitespace-nowrap">{{ $user->name }}</td>
            <td class="px-4 py-2 whitespace-nowrap">{{ $user->email }}</td>
            <td class="px-4 py-2 whitespace-nowrap space-x-2">
              <a href="{{ route('users.edit', $user) }}"
                 class="text-indigo-600 hover:underline">Edit</a>
              <form action="{{ route('users.destroy', $user) }}" method="POST" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit"
                        onclick="return confirm('Yakin menghapus user ini?')"
                        class="text-red-600 hover:underline">
                  Hapus
                </button>
              </form>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
@endsection
