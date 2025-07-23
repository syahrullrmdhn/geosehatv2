@extends('layouts.guest')
@section('title','Verifikasi 2FA')

@section('content')
<div class="max-w-md mx-auto py-6">
  <h2 class="text-2xl font-semibold mb-4">Masukkan Kode OTP</h2>
  @if(session('two_factor:status'))
    <div class="mb-4 p-3 bg-blue-50 border rounded text-blue-700">
      {{ session('two_factor:status') }}
    </div>
  @endif
  <form method="POST" action="{{ route('2fa.verify.post') }}" class="bg-white p-6 rounded border space-y-4">
    @csrf
    <label>
      <span>Kode 6-digit</span>
      <input name="code" type="text" autofocus class="mt-1 block w-full border rounded p-2">
    </label>
    @error('code')<p class="text-xs text-red-600">{{ $message }}</p>@enderror
    <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded">Verifikasi</button>
  </form>
</div>
@endsection
