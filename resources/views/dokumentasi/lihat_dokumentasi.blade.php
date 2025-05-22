@extends($layout)

@section('content')
<div class="container py-4">
    <div class="bg-white rounded-3 p-4" style="margin-left: 260px; margin-top: 40px; height: auto; ">
        <div class="card p-4 shadow-lg border-0">
        <h1 class="h4 fw-bold mb-3">Judul Dokumentasi : {{ $dokumentasi->judul_dokumentasi }}</h1>
        @if (!empty($dokumentasi->deskripsi))
            <p class="text-secondary mb-1"><strong>Deskripsi:</strong></p>
             {{-- Deskripsi dokumentasi (render dengan HTML dari TinyMCE) --}}
            <div class="mb-4">
                {!! $dokumentasi->deskripsi !!}
            </div>
        @endif

        {{-- Tampilkan file-file dokumentasi jika ada --}}
        @if ($dokumentasi->files->isNotEmpty())
            @foreach ($dokumentasi->files as $fileDokumentasi)
                @if (Str::endsWith($fileDokumentasi->file_path, ['jpg', 'jpeg', 'png']))
                    <img src="{{ asset('storage/' . $fileDokumentasi->file_path) }}" alt="Dokumentasi" class="img-fluid rounded shadow-sm mb-3">
                @elseif (Str::endsWith($fileDokumentasi->file_path, 'pdf'))
                    <embed src="{{ asset('storage/' . $fileDokumentasi->file_path) }}" type="application/pdf" width="100%" height="600px" class="mb-3" />
                @else
                    <a href="{{ asset('storage/' . $fileDokumentasi->file_path) }}" target="_blank" class="text-decoration-underline text-primary">Lihat File</a>
                @endif
                @if (!$loop->last)
                    <hr class="my-3"> {{-- garis pemisah antar file jika ada lebih dari satu --}}
                @endif
            @endforeach
        @endif

            <div>
                <a href="{{ route('dokumentasi.downloadPDF', $dokumentasi->id_dokumentasi) }}" 
                   class="btn btn-primary w-auto d-inline-block">
                    Download
                </a>
            </div>
    </div>
</div>
</div>
@endsection