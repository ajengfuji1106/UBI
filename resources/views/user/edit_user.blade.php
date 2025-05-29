@extends('partials.admin.main')

@section('content')
<div>
    <div class="bg-white rounded-3 p-4" style="margin-left: 260px; margin-top: 75px; height: auto; ">
            <div class="card p-4 shadow-lg border-0">
            <!-- Header -->
            <div class="d-flex align-items-center mb-4">
                <img src="{{ asset('assets/edituser.png') }}" class="me-2" style="width: 24px; height: 24px;" alt="edit pengguna">
                <h2 class="h5 mb-0 fw-semibold">Edit Pengguna</h2>
            </div>

            <!-- Notifikasi Sukses -->
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Form Edit Pengguna -->
            <form action="{{ route('user.update', ['id' => $user->id]) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Nama -->
                <div class="mb-3 row">
                    <label class="col-sm-3 col-form-label fw-semibold">Nama*</label>
                    <div class="col-sm-9">
                        <input type="text" name="name" class="form-control" required value="{{ old('name', $user->name) }}">
                    </div>
                </div>

                <!-- Profile Image -->
                <div class="mb-3 row align-items-center">
                    <label class="col-sm-3 col-form-label fw-semibold">Profile Image*</label>
                    <div class="col-sm-9">
                        <div class="d-flex align-items-center mb-2">
                            <div class="rounded-circle overflow-hidden bg-light d-flex justify-content-center align-items-center" style="width: 64px; height: 64px;">
                                <img id="previewImage" src="{{ $user->foto ? asset('storage/'.$user->foto) : asset('assets/avatar.png') }}" 
                                     class="img-fluid" style="max-height: 48px;" alt="Foto Profil">
                            </div>
                        </div>
                        <input type="file" name="foto" id="fileInput" class="d-none" accept="image/*" onchange="previewFile()">
                        <div id="dropArea" class="form-control text-center py-3 px-2" style="cursor: pointer;" 
                             onclick="document.getElementById('fileInput').click()">
                            <p id="uploadText" class="mb-1 text-muted">Click to upload or drag and drop</p>
                            <p id="infoText" class="text-muted small">SVG, PNG, JPG, GIF (max. 800x400px)</p>
                        </div>
                    </div>
                </div>

                <!-- Telephone -->
                <div class="mb-3 row">
                    <label class="col-sm-3 col-form-label fw-semibold">Telephone*</label>
                    <div class="col-sm-9">
                        <input type="text" name="telephone" class="form-control" required value="{{ old('telephone', $user->telephone) }}">
                    </div>
                </div>

                <!-- Email -->
                <div class="mb-3 row">
                    <label class="col-sm-3 col-form-label fw-semibold">Email*</label>
                    <div class="col-sm-9">
                        <input type="email" name="email" class="form-control" required autocomplete="off" value="{{ old('email', $user->email) }}">
                    </div>
                </div>

                <!-- Password -->
                <div class="mb-3 row">
                    <label class="col-sm-3 col-form-label fw-semibold">Password (Opsional)</label>
                    <div class="col-sm-9">
                        <input type="password" name="password" class="form-control" placeholder="Biarkan kosong jika tidak ingin mengubah password">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-sm-3 col-form-label fw-semibold">Konfirmasi Password Baru</label>
                    <div class="col-sm-9">
                        <input type="password" name="password_confirmation" class="form-control">
                    </div>
                </div>

                <!-- Tombol -->
                <div class="d-flex justify-content-end">
                    <a href="{{ route('kelolauser') }}" class="btn btn-danger me-2">Cancel</a>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function previewFile() {
        const fileInput = document.getElementById('fileInput');
        const file = fileInput.files[0];
        const preview = document.getElementById('previewImage');
        const uploadText = document.getElementById('uploadText');
        const infoText = document.getElementById('infoText');

        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
            };
            reader.readAsDataURL(file);

            uploadText.textContent = file.name;
            infoText.style.display = "none";
        } else {
            uploadText.textContent = "Click to upload or drag and drop";
            infoText.style.display = "block";
        }
    }

    function handleDrop(event) {
        event.preventDefault();
        const fileInput = document.getElementById('fileInput');

        if (event.dataTransfer.files.length > 0) {
            fileInput.files = event.dataTransfer.files;
            previewFile();
        }
    }

    document.getElementById('dropArea').addEventListener('dragover', function(event) {
        event.preventDefault();
        this.classList.add('bg-light');
    });

    document.getElementById('dropArea').addEventListener('dragleave', function() {
        this.classList.remove('bg-light');
    });

    document.getElementById('dropArea').addEventListener('drop', handleDrop);
</script>
@endsection
