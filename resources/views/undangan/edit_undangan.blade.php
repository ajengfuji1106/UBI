@extends('partials.admin.main')

@section('content')
<div class="container py-4 px-4 mx-auto d-flex justify-content-center" style="margin-top: 65px;">
    <div class="col-md-8 offset-md-2 bg-white p-4 rounded shadow">

        <h2 class="mb-4 fw-bold">Edit Undangan</h2>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('undangan.update', $undangan->id_undangan) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Judul Rapat *</label>
                <input type="text" name="judul_rapat" class="form-control" value="{{ $undangan->rapat->judul_rapat }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Tanggal Rapat *</label>
                <input type="date" name="tanggal_rapat" class="form-control" value="{{ $undangan->rapat->tanggal_rapat }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Jam Rapat *</label>
                <input type="time" name="waktu_rapat" class="form-control" value="{{ $undangan->rapat->waktu_rapat }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Lokasi Rapat *</label>
                <input type="text" name="lokasi_rapat" class="form-control" value="{{ $undangan->rapat->lokasi_rapat }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Kategori Rapat *</label>
                <select name="kategori_rapat" class="form-select">
                    <option value="Internal" {{ $undangan->rapat->kategori_rapat == 'Internal' ? 'selected' : '' }}>Internal</option>
                    <option value="Eksternal" {{ $undangan->rapat->kategori_rapat == 'Eksternal' ? 'selected' : '' }}>Eksternal</option>
                </select>
            </div>
            {{-- <div class="mb-3"> --}}
                {{-- <label class="form-label">Kategori Rapat *</label> --}}
                {{-- <input type="text" name="kategori_rapat" class="form-control" value="{{ $undangan->rapat->kategori_rapat }}" required> --}}
            {{-- </div> --}}

            <div class="mb-3">
                <label class="form-label">Upload Undangan (Opsional)</label>
                <div id="dropArea" class="form-control p-4 text-center rounded">
                    <input type="file" name="file_undangan" class="d-none" id="fileInput">
                    <p class="text-muted mb-1" id="uploadText">Drag and Drop here or</p>
                    <p class="small text-secondary" id="infoText">Allowed: PDF, DOCX, JPG (max 5MB)</p>
                    <button type="button" onclick="document.getElementById('fileInput').click()" class="btn btn-outline-success btn-sm">Select file</button>
                </div>
                @if($undangan->file_undangan)
                    <p class="mt-2 text-muted">File saat ini: 
                        <a href="{{ asset('storage/' . $undangan->file_undangan) }}" target="_blank" class="text-primary">Lihat Undangan</a>
                    </p>
                @endif
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">Save Changes</button>
                <a href="{{ route('kelolarapat') }}" class="btn btn-danger">Cancel</a>
            </div>
        </form>
    </div>
</div>

<script>
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
        dropArea.addEventListener(event, function () {
            dropArea.classList.add("bg-light");
        });
    });

    ["dragleave", "drop"].forEach(event => {
        dropArea.addEventListener(event, function () {
            dropArea.classList.remove("bg-light");
        });
    });

    dropArea.addEventListener("drop", function (e) {
        if (e.dataTransfer.files.length) {
            fileInput.files = e.dataTransfer.files;
            updateFileName(fileInput.files[0]);
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
</script>
@endsection
