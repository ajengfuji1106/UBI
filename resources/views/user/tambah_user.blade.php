@extends('partials.admin.main')

@section('content')
<div>
    <div class="bg-white rounded-3 p-4" style="margin-left: 260px; margin-top: 75px; height: auto; ">
            <div class="card p-4 shadow-lg border-0">

            <!-- Header -->
            <div class="d-flex align-items-center mb-4">
                <img src="{{ asset('assets/tambahpartisipan.png') }}" class="me-2" width="24" height="24" alt="tambah partisipan">
                <h2 class="h5 mb-0">Tambah Pengguna Baru</h2>
            </div>

            <!-- Notifikasi Sukses -->
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Form Tambah Pengguna -->
            <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Nama -->
                <div class="mb-3 row">
                    <label class="col-sm-3 col-form-label fw-semibold">Nama*</label>
                    <div class="col-sm-9">
                        <input type="text" name="name" class="form-control" required placeholder="Masukkan Nama Pengguna">
                    </div>
                </div>

                <div class="mb-3 row align-items-center">
                    <label class="col-sm-3 col-form-label fw-semibold">Profile Image</label>
                    <div class="col-sm-9">
                        <div class="d-flex align-items-center gap-3 mb-2">
                            <div class="rounded-circle bg-light d-flex justify-content-center align-items-center overflow-hidden" style="width: 60px; height: 60px;">
                                <img id="previewImage" src="{{ asset('assets/addpict.png') }}" alt="Preview" class="img-fluid" style="object-fit: contain; width: 40px; height: 40px;">
                            </div>
                        </div>
                        <input type="file" name="foto" id="fileInput" class="d-none" accept="image/*" onchange="previewFile()">
                        <div id="dropArea" class="form-control text-center py-3 px-2" onclick="document.getElementById('fileInput').click()" style="cursor: pointer;">
                            <p class="mb-1 text-muted" id="uploadText">Click to upload or drag and drop</p>
                            <p class="text-muted small" id="infoText">SVG, PNG, JPG, GIF (max. 800x400px)</p>
                        </div>
                    </div>
                </div>

                <!-- Telephone -->
                <div class="mb-3 row">
                    <label class="col-sm-3 col-form-label fw-semibold">Telephone*</label>
                    <div class="col-sm-9">
                        <input type="text" name="telephone" class="form-control" required placeholder="Tambahkan Nomer Telephone yang terhubung dengan Whatsapp">
                    </div>
                </div>

                <!-- Email -->
                <div class="mb-3 row">
                    <label class="col-sm-3 col-form-label fw-semibold">Email*</label>
                    <div class="col-sm-9">
                        <input type="email" name="email" class="form-control" required placeholder="Tambahkan Alamat Email" autocomplete="off">
                    </div>
                </div>

                <!-- Password -->
                <div class="mb-3 row">
                    <label class="col-sm-3 col-form-label fw-semibold">Password*</label>
                    <div class="col-sm-9">
                        <input type="password" name="password" class="form-control" required placeholder="Tambahkan Password Pengguna" autocomplete="new-password">
                    </div>
                </div>

                <!-- Tombol -->
                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('kelolauser') }}" class="btn btn-danger me-2">Cancel</a>
                    <button type="submit" class="btn btn-primary">Save</button>
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
