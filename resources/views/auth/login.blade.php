@extends('layouts.app')

@section('title','Login GeoSehat')

@section('content')
<div class="w-full max-w-md bg-white p-8 rounded shadow">
  <h2 class="text-2xl mb-6 text-center">Masuk ke GeoSehat</h2>

  @if($errors->any())
    <div class="mb-4 text-red-600">
      {{ $errors->first() }}
    </div>
  @endif

  <form action="{{ route('login') }}" method="POST" class="space-y-4">
    @csrf
    <div>
      <label class="block mb-1">Email</label>
      <input type="email" name="email" value="{{ old('email') }}" required
             class="w-full border rounded px-3 py-2 focus:outline-none focus:ring">
    </div>
    <div>
      <label class="block mb-1">Password</label>
      <input type="password" name="password" required
             class="w-full border rounded px-3 py-2 focus:outline-none focus:ring">
    </div>
    <div class="flex items-center">
      <input type="checkbox" name="remember" id="remember" class="mr-2">
      <label for="remember" class="select-none">Ingat saya</label>
    </div>
    <button type="submit"
            class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700">
      Login
    </button>
  </form>
</div>
@endsection
