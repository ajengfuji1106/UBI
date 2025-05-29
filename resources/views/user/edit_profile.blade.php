@extends($layout)

@section('content')

<div class="bg-white rounded-3 p-4" style="margin-left: 260px; margin-top: 75px; height: auto; ">
        <div class="card p-4 shadow-lg border-0">
            <div class="bg-white rounded shadow-sm p-4 position-relative" style="border: 1px solid #e0e0e0;">
            <div class="position-relative text-center mb-4">
                <!-- Icon Ubah Password -->
                <div class="position-absolute top-50 end-0 translate-middle-y">
                    <a href="{{ route('profile.password') }}" class="btn btn-light p-2 rounded-circle shadow-sm">
                        <img src="{{ asset('assets/password.png') }}" alt="Lock" class="img-fluid" style="width: 20px; height: 20px;">
                    </a>
                </div>

                <!-- Foto Profil -->
                <img src="{{ $user->foto ? asset('storage/' . $user->foto) : asset('assets/avatar.png') }}"
                     class="rounded-circle mb-3" style="width: 100px; height: 100px; object-fit: cover;">

                <h2 class="h4 mb-1">{{ $user->name }}</h2>
                <p class="text-primary fw-semibold mb-0">{{ $user->role ?? 'User' }}</p>
            </div>

            <!-- Form Edit Profile -->
            <form action="{{ route('profile.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <h5 class="fw-bold">Account Details</h5>
                    <hr>
                    <div class="row g-4">
                        <!-- Nama -->
                        <div class="col-md-6">
                            <label class="form-label text-muted">Nama</label>
                            <input type="text" name="name" value="{{ $user->name }}" 
                                   class="form-control" required>
                        </div>

                        <!-- Telephone -->
                        <div class="col-md-6">
                            <label class="form-label text-muted">Telephone</label>
                            <input type="text" name="telephone" value="{{ $user->telephone }}" 
                                   class="form-control" required>
                        </div>

                        <!-- Password -->
                        <div class="col-md-6">
                            <label class="form-label text-muted">Password</label>
                            <input type="password" value="********" disabled
                                   class="form-control bg-light">
                        </div>

                        <!-- Email -->
                        <div class="col-md-6">
                            <label class="form-label text-muted">Email</label>
                            <input type="email" name="email" value="{{ $user->email }}" 
                                   class="form-control" required>
                        </div>
                    </div>
                </div>

                <!-- Tombol Action -->
                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('profile.show') }}" class="btn btn-danger">
                        Cancel
                    </a>
                    <button type="submit" class="btn btn-primary">
                        Save Changes
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>

@endsection
