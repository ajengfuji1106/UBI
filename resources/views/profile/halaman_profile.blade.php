@extends('layouts.app')

@section('content')

<div class="ml-64 d-flex min-vh-100 justify-content-center align-items-center">
    <div class="bg-white p-4 rounded shadow-lg w-100" style="max-width: 40rem;">
        <div class="position-relative text-center">
            <div class="position-absolute top-50 end-0 translate-middle-y d-flex space-x-2">
                <!-- Edit Profile Button -->
                <a href="{{ route('profile.edit') }}" class="btn btn-light p-2 rounded-circle">
                    <img src="{{ asset('assets/edituser.png') }}" alt="Edit" class="w-25 h-25">
                </a>
                
                <!-- Change Password Button -->
                <a href="{{ route('profile.password') }}" class="btn btn-light p-2 rounded-circle">
                    <img src="{{ asset('assets/password.png') }}" alt="Lock" class="w-25 h-25">
                </a>
            </div>

            <!-- Profile Picture -->
            <img src="{{ $user->foto ? asset('storage/' . $user->foto) : asset('images/default-profile.png') }}" 
                 class="w-25 h-25 rounded-circle mx-auto mb-4">

            <h2 class="h4 font-weight-semibold">{{ $user->nama }}</h2>
            <p class="text-muted">{{ $user->role ?? 'User' }}</p>
        </div>

        <div class="mt-4">
            <h3 class="h5 font-weight-semibold mb-2">Account Details</h3>
            <hr class="my-2">
            <div class="row g-4">
                <div class="col-md-6">
                    <p class="text-muted">Nama</p>
                    <p class="font-weight-semibold">{{ $user->nama }}</p>
                </div>
                <div class="col-md-6">
                    <p class="text-muted">Telephone</p>
                    <p class="font-weight-semibold">{{ $user->telephone }}</p>
                </div>
                <div class="col-md-6">
                    <p class="text-muted">Password</p>
                    <p class="font-weight-semibold">********</p>
                </div>
                <div class="col-md-6">
                    <p class="text-muted">Email</p>
                    <p class="font-weight-semibold">{{ $user->email }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
