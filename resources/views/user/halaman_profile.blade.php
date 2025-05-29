@extends($layout)

@section('content')

<div>
    <div class="bg-white rounded-3 p-4" style="margin-left: 260px; margin-top: 75px; height: auto; ">
            <div class="card p-4 shadow-lg border-0">
            <div class="bg-white rounded shadow-sm p-4 position-relative" style="border: 1px solid #e0e0e0;">
                
                <!-- Tombol Edit dan Ubah Password -->
                <div class="position-absolute" style="top: 20px; right: 20px; display: flex; gap: 10px;">
                    <a href="{{ route('profile.edit') }}" class="text-primary">
                        <img src="{{ asset('assets/edituser.png') }}" alt="Edit" style="width: 24px; height: 24px;">
                    </a>
                    <a href="{{ route('profile.password') }}" class="text-primary">
                        <img src="{{ asset('assets/password.png') }}" alt="Password" style="width: 24px; height: 24px;">
                    </a>
                </div>

                <!-- Foto dan Nama -->
                <div class="text-center"> 
                    <div class="position-relative d-inline-block" style="background: white; border-radius: 50%; padding: 20px;">
                        <img src="{{ $user->foto ? asset('storage/' . $user->foto) : asset('assets/avatar.png') }}" 
                            class="rounded-circle" style="width: 80px; height: 80px; object-fit: cover; background: white; padding: 5px;">
                        
                        <!-- Ikon Kamera -->
                        <div class="position-absolute bottom-0 start-50 translate-middle-x" 
                             style="transform: translate(-50%, 50%); cursor: pointer;" 
                             onclick="document.getElementById('uploadFoto').click()">
                            <img src="{{ asset('assets/camera.png') }}" alt="Camera" style="width: 20px; height: 20px;">
                        </div>
                
                        <!-- Input file tersembunyi -->
                        <form action="{{ route('user.uploadFoto') }}" method="POST" enctype="multipart/form-data" id="formUploadFoto">
                            @csrf
                            <input type="file" name="foto" id="uploadFoto" accept="image/*" style="display: none;" onchange="document.getElementById('formUploadFoto').submit()">
                        </form>
                    </div>
                                
                    <h5 class="mt-3 mb-1" style="font-weight: bold;">{{ $user->name }}</h5>
                    <p class="text-primary mb-4" style="font-size: 14px;">{{ $user->role ?? 'User' }}</p>
                </div>

                <!-- Detail Akun -->
                <div>
                    <h6 class="text-muted mb-2">Account Details</h6>
                    <hr>
                    <div class="row">
                        <div class="col-6 mb-3">
                            <small class="text-muted">Nama</small>
                            <p class="mb-0">{{ $user->name }}</p>
                        </div>
                        <div class="col-6 mb-3">
                            <small class="text-muted">Telephone</small>
                            <p class="mb-0">{{ $user->telephone }}</p>
                        </div>
                        <div class="col-6 mb-3">
                            <small class="text-muted">Password</small>
                            <p class="mb-0">********</p>
                        </div>
                        <div class="col-6 mb-3">
                            <small class="text-muted">Email</small>
                            <p class="mb-0">{{ $user->email }}</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

@endsection
