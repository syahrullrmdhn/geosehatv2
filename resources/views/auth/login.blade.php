@extends('layouts.guest')

@section('title', 'Login - Geosehat')

@section('content')
<div class="bg-white border border-gray-200 rounded-2xl shadow-xl px-8 py-10 flex flex-col">
    <div class="flex justify-center mb-6">
        <span class="text-3xl font-bold text-gray-900 tracking-tight select-none">
            geosehat<span class="text-blue-500">_</span>
        </span>
    </div>
    <h2 class="text-center text-2xl font-bold mb-1 text-gray-900">Login</h2>
    <p class="text-center text-gray-500 text-sm mb-7">Selamat datang kembali, masukkan kredensial Anda.</p>
    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf
        <div>
            <label for="email" class="block text-sm font-semibold mb-1 text-gray-700">Email</label>
            <input id="email" name="email" type="email" value="{{ old('email') }}" required
                class="w-full bg-gray-50 border border-gray-300 rounded-lg py-2 px-3 text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition placeholder-gray-400"/>
            @error('email')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div>
            <label for="password" class="block text-sm font-semibold mb-1 text-gray-700">Password</label>
            <div class="relative">
                <input id="password" name="password" type="password" required
                    class="w-full bg-gray-50 border border-gray-300 rounded-lg py-2 px-3 text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition placeholder-gray-400 pr-10"/>
                {{-- Option: Add password eye toggle here --}}
            </div>
            @error('password')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div class="flex items-center justify-between">
            <label class="flex items-center space-x-2 cursor-pointer">
                <input type="checkbox" name="remember" class="form-checkbox h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                <span class="text-sm text-gray-700">Ingat saya</span>
            </label>
            <a href="{{ route('password.request') }}" class="text-sm text-blue-600 hover:underline">Lupa password?</a>
        </div>
        <button type="submit"
            class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2.5 px-7 rounded-lg shadow hover:shadow-lg transition">
            Log in
        </button>
    </form>
    <div class="text-center mt-6">
        <p class="text-sm text-gray-500">
            Belum punya akun?
            <a href="{{ route('register') }}" class="text-blue-600 hover:underline font-medium">
                Register di sini
            </a>
        </p>
    </div>
</div>
@endsection
