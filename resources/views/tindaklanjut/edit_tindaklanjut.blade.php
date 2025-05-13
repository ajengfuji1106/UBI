@extends($layout)

@section('content')
<div class="bg-white rounded-3 p-4" style="margin-left: 260px; margin-top: 75px; height: auto; ">
    <div class="card p-4 shadow-lg border-0">
        <div class="card-body">
            <h2 class="card-title mb-4">Edit Tindak Lanjut</h2>

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('tindaklanjut.update', $tindaklanjut->id_tindaklanjut) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <input type="hidden" name="id_rapat" value="{{ $tindaklanjut->id_rapat }}">

                <!-- Judul Tugas -->
                <div class="mb-3">
                    <label class="form-label">Judul Tugas *</label>
                    <input 
                        type="text" 
                        name="judul_tugas" 
                        class="form-control" 
                        value="{{ $tindaklanjut->judul_tugas }}" 
                        required
                    >
                </div>

                <!-- Deadline -->
                <div class="mb-3">
                    <label class="form-label">Deadline *</label>
                    <input 
                        type="date" 
                        name="deadline_tugas" 
                        class="form-control" 
                        value="{{ $tindaklanjut->deadline_tugas }}"
                        required
                    >
                </div>

                <!-- Partisipan -->
                <div class="mb-3 position-relative">
                    <label class="form-label">Partisipan *</label>
                    <button type="button" class="form-control text-start" data-bs-toggle="dropdown" aria-expanded="false">
                        Masukkan Partisipan
                    </button>

                    <div class="dropdown-menu p-2 shadow" style="width: 300px; max-height: 200px; overflow-y: auto;">
                        <table class="table table-sm table-hover align-middle mb-0">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Role</th>
                                    <th>Pilih</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $user)
                                <tr>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->role }}</td>
                                    <td class="text-center">
                                        <input type="checkbox" name="id_user[]" value="{{ $user->id }}"
                                            data-nama="{{ $user->name }}"
                                            {{ in_array($user->id, $tindaklanjut->users->pluck('id')->toArray()) ? 'checked' : '' }}>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <ul id="selected-users" class="mt-2 list-group"></ul>
                </div>

                <!-- Detail Tugas -->
                <div class="mb-3">
                    <label class="form-label">Detail Tugas *</label>
                    <textarea id="editor" name="deskripsi_tugas" class="form-control">{!! $tindaklanjut->deskripsi_tugas !!}</textarea>
                </div>

                <!-- Lampiran -->
                <div class="mb-3">
                    <label class="form-label">Upload Lampiran</label>
                    <div id="dropArea" class="form-control p-4 text-center rounded" style="cursor: pointer;">
                        <input type="file" name="file_path" class="d-none" id="fileInput">
                        <p class="text-muted mb-1" id="uploadText">{{ $tindaklanjut->file_path ? basename($tindaklanjut->file_path) : 'Drag and Drop here or' }}</p>
                        <p class="text-muted small" id="infoText">{{ $tindaklanjut->file_path ? '' : 'Allowed: PDF, DOCX, JPG (max 5MB)' }}</p>
                        <button type="button" onclick="document.getElementById('fileInput').click()" class="btn btn-outline-success btn-sm">Select file</button>
                    </div>
                </div>

                <!-- Notifikasi Checkbox -->
                <div class="form-check mb-4">
                    <input class="form-check-input" type="checkbox" id="notifikasiCheck">
                    <label class="form-check-label fw-semibold text-dark" for="notifikasiCheck">
                        Kirim Notifikasi Tindak Lanjut
                    </label>
                </div>

                <!-- Tombol -->
                <div class="d-flex gap-2">
                    <a href="{{ route('meeting.detail', ['id' => $tindaklanjut->id_rapat]) }}" class="btn btn-danger">Cancel</a>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- JS TinyMCE dan Checkbox -->
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

    document.addEventListener('DOMContentLoaded', function() {
        const checkboxes = document.querySelectorAll('input[name="id_user[]"]');
        const dropdownButton = document.querySelector('.dropdown-menu').previousElementSibling;

        function updateSelectedUsers() {
            const selectedNames = [];
            checkboxes.forEach(checkbox => {
                if (checkbox.checked) {
                    selectedNames.push(checkbox.dataset.nama);
                }
            });
            dropdownButton.textContent = selectedNames.length > 0 ? selectedNames.join(', ') : 'Masukkan Partisipan';
        }

        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', updateSelectedUsers);
        });

        updateSelectedUsers();
    });
</script>
@endsection
