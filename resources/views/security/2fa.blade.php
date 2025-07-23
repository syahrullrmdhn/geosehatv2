@extends('layouts.app')
@section('title','Two-Factor Authentication')

@section('content')
<div class="max-w-md mx-auto py-6">
  <h2 class="text-2xl font-semibold mb-4">Two-Factor Authentication</h2>
  @if(session('success'))
    <div class="mb-4 p-3 bg-green-100 text-green-700">{{ session('success') }}</div>
  @endif
  <div class="bg-white border rounded p-6">
    <p>Status: <strong>{{ $user->two_factor_enabled ? 'Aktif' : 'Tidak Aktif' }}</strong></p>
    <p class="text-sm text-gray-500 mb-4">2FA mengirimkan kode via Telegram setiap login.</p>

    @if(!$user->two_factor_enabled)
      <form method="POST" action="{{ route('security.2fa.enable') }}" class="space-y-4">
        @csrf
        <label>
          <span class="text-sm">Telegram Chat ID</span>
          <input type="text" name="chat_id" value="{{ old('chat_id') }}"
                 class="mt-1 block w-full border rounded p-2">
        </label>
        @error('chat_id')<p class="text-xs text-red-600">{{ $message }}</p>@enderror
        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Aktifkan 2FA</button>
      </form>
    @else
      <form method="POST" action="{{ route('security.2fa.disable') }}">
        @csrf
        <button type="submit" class="px-4 py-2 border rounded">Nonaktifkan 2FA</button>
      </form>
    @endif
  </div>
</div>
@endsection
