@extends($layout)

@section('content')
<div class="bg-white rounded-3 p-4" style="margin-left: 260px; margin-top: 75px; height: auto; ">
        <div class="card p-4 shadow-lg border-0">
        <div class="card-body">
            <h2 class="h5 fw-semibold text-secondary mb-4">Upload Dokumentasi</h2>

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('dokumentasi.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id_rapat" value="{{ $id_rapat ?? '' }}">

                <!-- Judul Dokumentasi -->
                <div class="mb-3">
                    <label class="form-label fw-semibold">Judul Dokumentasi</label>
                    <input type="text" name="judul_dokumentasi" class="form-control" required>
                </div>

                <!-- Deskripsi -->
                <div class="mb-3">
                    <label for="editor" class="form-label fw-semibold">Deskripsi</label>
                    <textarea id="editor" name="deskripsi" class="form-control"></textarea>
                </div>

                <!-- File Upload -->
                <div class="mb-4">
                    <label class="form-label fw-semibold">Upload Dokumentasi *</label>
                        <div class="border border-dashed border-secondary-subtle rounded bg-light p-3">
                        <p class="text-muted small fst-italic">
                            Please upload square image, size less than 100KB
                        </p>

                        <div class="d-flex align-items-center gap-3">
                            <!-- Preview -->
                            <img src="{{ asset('assets/Placeholder Image.png') }}" alt="Preview" id="previewImage" class="rounded" width="50" height="50" style="opacity: 0.5;">

                            <!-- File input -->
                            <label class="btn btn-outline-success btn-sm mb-0">
                                Choose File
                                <input type="file" name="file_path[]" class="d-none" id="fileUpload" multiple>
                            </label>

                            <span class="text-muted small" id="fileName">No File Chosen</span>
                        </div>
                        <div id="previewContainer" class="d-flex flex-wrap gap-2 mt-3"></div>
                    </div>
                </div>

                <!-- Tombol -->
                <div class="d-flex gap-3">
                        <button type="submit" class="btn btn-primary">Save</button>
                    @if(auth()->user()->role == 'admin')
                        <a href="{{ route('meeting.detail', ['id' => $id_rapat]) }}" class="btn btn-danger">Cancel</a>
                    @else
                        <a href="{{ route('user.rapat.detail', ['id' => $id_rapat]) }}" class="btn btn-danger">Cancel</a>
                    @endif
                </div>
            </form>
        </div>
    </div>
</div>

<!-- TinyMCE -->
<script src="https://cdn.tiny.cloud/1/vweiq0f3ncoj00j6n3jcd0eallkmqx9pwj6oqwfn42cwdpw6/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    tinymce.init({
        selector: '#editor',
        api_key: 'vweiq0f3ncoj00j6n3jcd0eallkmqx9pwj6oqwfn42cwdpw6',
        height: 300,
        menubar: false,
        plugins: 'advlist autolink lists link charmap preview anchor searchreplace visualblocks code fullscreen insertdatetime media table help',
        toolbar: 'undo redo | bold italic underline | alignleft aligncenter alignright | bullist numlist outdent indent | removeformat | help'
    });

    document.addEventListener("DOMContentLoaded", function () {
        const fileInput = document.getElementById('fileUpload');
        const fileNameText = document.getElementById('fileName');
        const previewContainer = document.getElementById('previewContainer');

        fileInput.addEventListener('change', function () {
            previewContainer.innerHTML = ''; // Reset container
            const files = fileInput.files;

            if (files.length > 0) {
                fileNameText.textContent = `${files.length} file(s) selected`;

                Array.from(files).forEach(file => {
                    if (file.type.startsWith('image/')) {
                        const reader = new FileReader();
                        reader.onload = function (e) {
                            const img = document.createElement('img');
                            img.src = e.target.result;
                            img.className = "rounded border";
                            img.style.width = "50px";
                            img.style.height = "50px";
                            img.style.objectFit = "cover";
                            previewContainer.appendChild(img);
                        };
                        reader.readAsDataURL(file);
                    }
                });
            } else {
                fileNameText.textContent = 'No File Chosen';
            }
        });
    });
</script>
@endsection
