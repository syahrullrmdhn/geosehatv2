@extends('layouts.app')

@section('title', 'Tambah User')

@section('content')
<div class="max-w-lg mx-auto bg-white p-6 rounded-lg shadow space-y-6">
  <h2 class="text-2xl font-semibold text-gray-900">Tambah User</h2>

  <form action="{{ route('users.store') }}" method="POST" class="space-y-4">
    @csrf

    <div>
      <label class="block text-sm font-medium text-gray-700">Nama</label>
      <input type="text" name="name" value="{{ old('name') }}"
             class="mt-1 block w-full rounded border-gray-300 focus:ring-indigo-500 focus:border-indigo-500"/>
      @error('name')<p class="text-xs text-red-600">{{ $message }}</p>@enderror
    </div>

    <div>
      <label class="block text-sm font-medium text-gray-700">Email</label>
      <input type="email" name="email" value="{{ old('email') }}"
             class="mt-1 block w-full rounded border-gray-300 focus:ring-indigo-500 focus:border-indigo-500"/>
      @error('email')<p class="text-xs text-red-600">{{ $message }}</p>@enderror
    </div>

    <div>
      <label class="block text-sm font-medium text-gray-700">Password</label>
      <input type="password" name="password"
             class="mt-1 block w-full rounded border-gray-300 focus:ring-indigo-500 focus:border-indigo-500"/>
      @error('password')<p class="text-xs text-red-600">{{ $message }}</p>@enderror
    </div>

    <div>
      <label class="block text-sm font-medium text-gray-700">Confirm Password</label>
      <input type="password" name="password_confirmation"
             class="mt-1 block w-full rounded border-gray-300 focus:ring-indigo-500 focus:border-indigo-500"/>
    </div>

    <div class="text-right">
      <button type="submit"
              class="px-5 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition">
        Simpan
      </button>
    </div>
  </form>
</div>
@endsection
