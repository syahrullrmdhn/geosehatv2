@extends('layouts.app')

@section('title', 'Login - Geosehat')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-white relative overflow-hidden">
    <!-- Blue Glow Effect -->
    <div class="absolute inset-0 flex items-center justify-center pointer-events-none z-0">
        <div class="w-[600px] h-[600px] rounded-full bg-blue-100 opacity-70 blur-[120px]"></div>
    </div>
    <!-- Login Card -->
    <div class="relative z-10 w-full max-w-md px-8 py-10 bg-white border border-gray-200 rounded-2xl shadow-xl flex flex-col">
        <!-- Logo -->
        <div class="mb-6 flex justify-center">
            <span class="text-3xl font-semibold text-gray-900 tracking-wide select-none">geosehat<span class="text-blue-500">_</span></span>
        </div>
        <!-- Heading -->
        <h2 class="text-gray-900 text-2xl font-bold mb-1">Login</h2>
        <p class="text-gray-600 text-sm mb-6">Selamat datang kembali, masukkan kredensial Anda untuk melanjutkan.</p>

        <!-- Social login -->
        <button type="button" class="flex items-center justify-center gap-2 w-full border border-gray-300 rounded-lg py-2.5 text-gray-800 font-medium hover:bg-gray-50 transition mb-5">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 .297c-6.63 0-12 5.373-12 12 0 5.303 3.438 9.8 8.205 11.385.6.113.82-.258.82-.577 0-.285-.011-1.04-.017-2.04-3.338.726-4.042-1.415-4.042-1.415-.546-1.387-1.333-1.756-1.333-1.756-1.09-.745.083-.729.083-.729 1.205.084 1.84 1.237 1.84 1.237 1.07 1.835 2.809 1.305 3.495.998.108-.776.418-1.305.762-1.605-2.665-.305-5.466-1.332-5.466-5.932 0-1.31.469-2.381 1.236-3.221-.124-.304-.536-1.527.117-3.176 0 0 1.008-.322 3.301 1.23a11.48 11.48 0 013.003-.404c1.019.005 2.047.138 3.003.404 2.291-1.553 3.297-1.23 3.297-1.23.655 1.649.243 2.872.12 3.176.77.84 1.235 1.911 1.235 3.221 0 4.61-2.803 5.625-5.475 5.921.43.371.823 1.102.823 2.222 0 1.604-.015 2.896-.015 3.286 0 .322.216.694.825.576C20.565 22.092 24 17.592 24 12.297c0-6.627-5.373-12-12-12"/></svg>
            Login Dengan Github
        </button>

        <!-- Or divider -->
        <div class="flex items-center my-4">
            <div class="flex-grow border-t border-gray-300"></div>
            <span class="mx-3 text-gray-500 text-sm">Atau</span>
            <div class="flex-grow border-t border-gray-300"></div>
        </div>

        <!-- Login Form -->
        <form class="space-y-5">
            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-semibold text-gray-900 mb-1">Email</label>
                <input id="email" name="email" type="email" placeholder="saul@domain.com" required 
                    class="w-full bg-transparent border border-gray-300 rounded-lg py-2 px-3 text-gray-800 focus:outline-none focus:border-blue-500 transition placeholder-gray-400"/>
            </div>
            <!-- Password -->
            <div>
                <label for="password" class="block text-sm font-semibold text-gray-900 mb-1">Password</label>
                <div class="relative">
                    <input id="password" name="password" type="password" placeholder="••••••••" required 
                        class="w-full bg-transparent border border-gray-300 rounded-lg py-2 px-3 text-gray-800 focus:outline-none focus:border-blue-500 transition placeholder-gray-400 pr-10"/>
                    <button type="button" class="absolute inset-y-0 right-0 flex items-center px-3 text-gray-500 hover:text-gray-700 focus:outline-none" tabindex="-1">
                        <!-- Eye Icon -->
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0zm7 0c0 5-7 9-7 9s-7-4-7-9a7 7 0 0114 0z"/>
                        </svg>
                    </button>
                </div>
            </div>
            <!-- Remember & Forgot -->
            <div class="flex items-center justify-between">
                <label class="flex items-center space-x-2">
                    <input type="checkbox" class="form-checkbox rounded text-blue-500 focus:ring-0" checked>
                    <span class="text-sm text-gray-800">Ingat saja saya</span>
                </label>
                <a href="#" class="text-sm text-gray-600 hover:underline hover:text-blue-600 transition">Lupa password?</a>
            </div>
            <!-- Register & Submit -->
            <div class="flex items-center justify-between mt-3">
                <a href="#" class="text-sm text-gray-600 hover:underline hover:text-blue-600 transition">Register</a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-7 rounded-lg shadow transition">Log in</button>
            </div>
        </form>
    </div>
</div>
@endsection