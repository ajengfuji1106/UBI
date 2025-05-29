@extends($layout)

@section('content')
<div class="bg-white rounded-3 p-4" style="margin-left: 260px; margin-top: 75px; height: auto; ">
        <div class="card p-4 shadow-lg border-0">
        <div class="bg-white rounded shadow-sm p-4 position-relative" style="border: 1px solid #e0e0e0;">
        <div class="position-relative text-center mb-4">
            <!-- Tombol Edit -->
            <a href="{{ route('profile.edit', $user->id) }}" 
               class="btn btn-light position-absolute top-0 end-0 p-2 rounded-circle shadow-sm">
                <img src="{{ asset('assets/edituser.png') }}" alt="Edit" style="width: 20px; height: 20px;">
            </a>

            <!-- Foto Profil -->
            <img src="{{ $user->foto ? asset('storage/' . $user->foto) : asset('assets/avatar.png') }}"
                 class="rounded-circle mb-3" style="width: 96px; height: 96px; object-fit: cover;">

            <h2 class="h5 fw-semibold mb-1">{{ $user->name }}</h2>
            <p class="text-primary mb-0">{{ $user->role ?? 'User' }}</p>
        </div>

        <!-- Form Ubah Password -->
        <div class="mt-4">
            <h5 class="fw-bold mb-3">Password Setting</h5>
            <hr class="mb-4">

            <form action="{{ route('profile.password.update') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label text-muted">Old Password</label>
                    <input type="password" name="old_password" class="form-control" placeholder="Enter Old Password">
                </div>

                <div class="mb-3">
                    <label class="form-label text-muted">New Password</label>
                    <input type="password" name="new_password" class="form-control" placeholder="Enter New Password">
                </div>

                <div class="mb-4">
                    <label class="form-label text-muted">Confirm Password</label>
                    <input type="password" name="confirm_password" class="form-control" placeholder="Enter Confirm Password">
                </div>

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
</div>
@endsection
