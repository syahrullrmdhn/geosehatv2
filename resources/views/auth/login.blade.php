@extends('layouts.app')

@section('title', 'Login - Geosehat')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-white px-4 relative overflow-hidden">
    <div class="absolute inset-0 flex items-center justify-center pointer-events-none z-0">
        <div class="w-[600px] h-[600px] rounded-full bg-blue-100 opacity-70 blur-[120px]"></div>
    </div>

    <div class="relative z-10 w-full max-w-md px-8 py-10 bg-white border border-gray-200 rounded-2xl shadow-xl flex flex-col">
        <div class="mb-6 flex justify-center">
            <span class="text-3xl font-semibold text-gray-900 tracking-wide select-none">geosehat<span class="text-blue-500">_</span></span>
        </div>

        <div class="text-center mb-8">
            <h2 class="text-gray-900 text-2xl font-bold mb-1">Login</h2>
            <p class="text-gray-600 text-sm">Selamat datang kembali, masukkan kredensial Anda.</p>
        </div>

        <button type="button" class="flex items-center justify-center gap-3 w-full border border-gray-300 rounded-lg py-2.5 text-gray-800 font-medium hover:bg-gray-50 transition">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path fill-rule="evenodd" d="M12 2C6.477 2 2 6.477 2 12c0 4.418 2.865 8.168 6.839 9.492.5.092.682-.217.682-.482 0-.237-.009-.868-.014-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.031-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.203 2.398.1 2.651.64.7 1.03 1.595 1.03 2.688 0 3.848-2.338 4.695-4.566 4.942.359.308.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.001 10.001 0 0022 12c0-5.523-4.477-10-10-10z" clip-rule="evenodd" /></svg>
            <span>Login Dengan Github</span>
        </button>

        <div class="flex items-center my-6">
            <div class="flex-grow border-t border-gray-300"></div>
            <span class="mx-3 text-gray-500 text-sm">Atau</span>
            <div class="flex-grow border-t border-gray-300"></div>
        </div>

        <form class="space-y-6">
            <div>
                <label for="email" class="block text-sm font-semibold text-gray-900 mb-2">Email</label>
                <input id="email" name="email" type="email" placeholder="nama@domain.com" required
                       class="w-full bg-transparent border border-gray-300 rounded-lg py-2 px-3 text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-300 focus:border-blue-500 transition placeholder-gray-400"/>
            </div>
            <div>
                <label for="password" class="block text-sm font-semibold text-gray-900 mb-2">Password</label>
                <div class="relative">
                    <input id="password" name="password" type="password" placeholder="••••••••" required
                           class="w-full bg-transparent border border-gray-300 rounded-lg py-2 px-3 text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-300 focus:border-blue-500 transition placeholder-gray-400 pr-10"/>
                    <button type="button" class="absolute inset-y-0 right-0 flex items-center px-3 text-gray-500 hover:text-gray-700 focus:outline-none" tabindex="-1">
                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                           <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                           <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </button>
                </div>
            </div>
            <div class="flex items-center justify-between">
                <label class="flex items-center space-x-2 cursor-pointer">
                    <input type="checkbox" class="form-checkbox h-4 w-4 rounded text-blue-600 focus:ring-blue-500 border-gray-300">
                    <span class="text-sm text-gray-800">Ingat saya</span>
                </label>
                <a href="#" class="text-sm text-blue-600 hover:underline transition">Lupa password?</a>
            </div>

            <div>
                 <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2.5 px-7 rounded-lg shadow-md hover:shadow-lg transition-transform transform hover:-translate-y-px">Log in</button>
            </div>
        </form>
        
        <div class="text-center mt-6">
            <p class="text-sm text-gray-600">
                Belum punya akun? <a href="#" class="text-blue-600 hover:underline font-medium">Register di sini</a>
            </p>
        </div>
    </div>
</div>
@endsection