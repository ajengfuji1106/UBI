@extends($layout)

@section('content')
<div class="container mt-5">
    <div class="bg-white rounded-3 p-4" style="margin-left: 260px; margin-top: 75px; height: auto; ">
            <div class="card p-4 shadow-lg border-0">
                <div class="card-body">
                    <h2 class="h5 mb-4 fw-bold">Edit Notulensi</h2>

                    <form action="{{ route('notulensi.update', $notulensi->id_notulensi) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <input type="hidden" name="id_rapat" value="{{ $notulensi->id_rapat }}">

                        <!-- Input Judul Notulensi -->
                        <div class="mb-3">
                            <label for="judul_notulensi" class="form-label">Judul Notulensi</label>
                            <input 
                                type="text" 
                                id="judul_notulensi" 
                                name="judul_notulensi" 
                                class="form-control" 
                                value="{{ $notulensi->judul_notulensi }}" 
                                required
                            >
                        </div>

                        <!-- Input TinyMCE -->
                        <div class="mb-3">
                            <label for="editor" class="form-label">Notes</label>
                            <textarea 
                                id="editor" 
                                name="konten_notulensi" 
                                class="form-control"
                            >{{ $notulensi->konten_notulensi }}</textarea>
                        </div>

                        <!-- Tombol Aksi -->
                         <!-- Tombol -->
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">Update</button>
                            <a href="{{ route('meeting.detail', ['id' => $notulensi->id_rapat]) }}"  class="btn btn-danger">Cancel</a>
                        </div>
                    </form>
                </div>
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
        toolbar: 'undo redo | bold italic underline | alignleft aligncenter alignright | bullist numlist outdent indent | removeformat | help',
        forced_root_block: false,
        force_br_newlines: true,
        force_p_newlines: false
    });
</script>
@endsection
