@extends('partials.admin.main')

@section('content')
<div class="container py-4 px-4 mx-auto d-flex justify-content-center" style="margin-top: 65px;">
    <div class="col-md-8 offset-md-2 bg-white p-4 rounded shadow">
        <h2 class="h4 fw-bold mb-4">Tambah Undangan</h2>

        <form action="{{ route('undangan.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label class="form-label">Judul Rapat *</label>
                <input type="text" name="judul_rapat" class="form-control" placeholder="Masukkan Judul Rapat" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Tanggal Rapat *</label>
                <input type="date" name="tanggal_rapat" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Waktu Rapat *</label>
                <input type="time" name="waktu_rapat" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Lokasi Rapat *</label>
                <input type="text" name="lokasi_rapat" class="form-control" placeholder="Masukkan Lokasi Rapat" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Kategori Rapat *</label>
                <select name="kategori_rapat" class="form-select" required>
                    <option value="Internal">Internal</option>
                    <option value="Eksternal">Eksternal</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Upload Undangan *</label>
                <div id="dropArea" class="form-control p-4 text-center rounded" style="cursor: pointer;">
                    <input type="file" name="file_undangan" class="d-none" id="fileInput" required>
                    <p class="text-muted mb-1" id="uploadText">Drag and Drop here or</p>
                    <p class="text-muted small" id="infoText">Allowed: PDF, DOCX, JPG (max 5MB)</p>
                    <button type="button" onclick="document.getElementById('fileInput').click()" class="btn btn-outline-success btn-sm">Select file</button>
                </div>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">Save</button>
                <a href="{{ url()->previous() }}" class="btn btn-danger">Cancel</a>
            </div>
        </form>
    </div>
</div>

<script>

    //script untuk drag and drop
    document.addEventListener("DOMContentLoaded", function () {
        let dropArea = document.getElementById("dropArea");
        let fileInput = document.getElementById("fileInput");
        let uploadText = document.getElementById("uploadText");
        let infoText = document.getElementById("infoText");

        ["dragenter", "dragover", "dragleave", "drop"].forEach(event => {
            dropArea.addEventListener(event, function (e) {
                e.preventDefault();
                e.stopPropagation();
            });
        });

        ["dragenter", "dragover"].forEach(event => {
            dropArea.classList.add("bg-secondary-subtle");
        });

        ["dragleave", "drop"].forEach(event => {
            dropArea.classList.remove("bg-secondary-subtle");
        });

        dropArea.addEventListener("drop", function (e) {
            if (e.dataTransfer.files.length) {
                fileInput.files = e.dataTransfer.files;
                updateFileName(e.dataTransfer.files[0]);
            }
        });

        document.querySelector('form').addEventListener('submit', function (e) {
        let judul = document.querySelector('[name="judul_rapat"]').value.trim();
        let tanggal = document.querySelector('[name="tanggal_rapat"]').value.trim();
        let waktu = document.querySelector('[name="waktu_rapat"]').value.trim();
        let lokasi = document.querySelector('[name="lokasi_rapat"]').value.trim();
        let kategori = document.querySelector('[name="kategori_rapat"]').value.trim();
        let file = document.getElementById('fileInput').files[0];

        if (!judul || !tanggal || !waktu || !lokasi || !kategori || !file) {
            e.preventDefault();
            Swal.fire({
                icon: 'warning',
                title: 'Isi Semua Kolom!',
                text: 'Semua inputan wajib diisi.',
            });
            return;
        }

        if (file.size > 5 * 1024 * 1024) { // lebih dari 5MB
            e.preventDefault();
            Swal.fire({
                icon: 'error',
                title: 'File Terlalu Besar!',
                text: 'Ukuran file maksimal 5MB.',
            });
            return;
        }
        });


        fileInput.addEventListener("change", function () {
            if (fileInput.files.length) {
                updateFileName(fileInput.files[0]);
            }
        });

        function updateFileName(file) {
            uploadText.textContent = file.name;
            infoText.style.display = "none";
        }
    });

    @if(session('success'))
    Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: '{{ session('success') }}',
        confirmButtonColor: '#3085d6'
    });
    @endif
</script>
@endsection
