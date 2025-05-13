@extends('layouts.app')

@section('content')

<div class="ml-64 d-flex min-vh-100 justify-content-center align-items-center">
    <div class="container px-5 py-5">
        <div class="bg-white p-4 rounded shadow-lg w-100 mx-auto" style="max-width: 40rem;">
            
            <div class="position-relative text-center">
                <!-- Password Icon -->
                <div class="position-absolute top-50 end-0 translate-middle-y d-flex">
                    <a href="{{ route('profile.password') }}" class="btn btn-light p-2 rounded-circle">
                        <img src="{{ asset('assets/password.png') }}" alt="Lock" class="w-25 h-25">
                    </a>
                </div>

                <!-- Profile Picture -->
                <img src="{{ $user->foto ? asset('storage/' . $user->foto) : asset('images/default-profile.png') }}" 
                     class="w-25 h-25 rounded-circle mx-auto mb-4">
                     
                <h2 class="h4 font-weight-semibold">{{ $user->nama }}</h2>
                <p class="text-primary font-weight-medium">{{ $user->role ?? 'User' }}</p>
            </div>

            <!-- Edit Profile Form -->
            <form action="{{ route('profile.update', $user->id_user) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mt-4">
                    <h3 class="h5 font-weight-semibold mb-2">Account Details</h3>
                    <hr class="my-2">

                    <div class="row g-4">
                        <!-- Name -->
                        <div class="col-md-6">
                            <label class="form-label text-muted">Nama</label>
                            <input type="text" name="nama" value="{{ $user->nama }}" 
                                   class="form-control">
                        </div>
                        <!-- Telephone -->
                        <div class="col-md-6">
                            <label class="form-label text-muted">Telephone</label>
                            <input type="text" name="telephone" value="{{ $user->telephone }}" 
                                   class="form-control">
                        </div>
                        <!-- Password -->
                        <div class="col-md-6">
                            <label class="form-label text-muted">Password</label>
                            <input type="password" name="password" value="********" disabled
                                   class="form-control bg-light" readonly>
                        </div>
                        <!-- Email -->
                        <div class="col-md-6">
                            <label class="form-label text-muted">Email</label>
                            <input type="email" name="email" value="{{ $user->email }}" 
                                   class="form-control">
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="d-flex justify-content-end mt-4">
                        <a href="{{ route('profile.show') }}" class="btn btn-danger me-3">
                            Cancel
                        </a>
                        <button type="submit" class="btn btn-primary">
                            Save Changes
                        </button>
                    </div>

                </div>
            </form>
            
        </div>
    </div>
</div>

@endsection
