@extends('layouts.app')
@section('title','Profil Anda')

@section('content')
<div class="max-w-3xl mx-auto py-10 space-y-8">

    <div class="bg-white border shadow rounded-lg p-6">
        <h2 class="text-lg font-semibold mb-3">Informasi Profil</h2>
        @include('profile.partials.update-profile-information-form')
    </div>

    <div class="bg-white border shadow rounded-lg p-6">
        <h2 class="text-lg font-semibold mb-3">Ganti Password</h2>
        @include('profile.partials.update-password-form')
    </div>

    <div class="bg-white border shadow rounded-lg p-6">
        <h2 class="text-lg font-semibold mb-3 text-red-700">Hapus Akun</h2>
        @include('profile.partials.delete-user-form')
    </div>

</div>
@endsection
