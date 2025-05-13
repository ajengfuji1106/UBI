@extends($layout)

@section('content')
<div class="container mt-4">
    <div class="bg-white rounded-3 p-4" style="margin-left: 260px; margin-top: 75px; height: auto; ">
            <div class="card p-4 shadow-lg border-0">
                <div class="card-body">
                    <h1 class="h4 fw-bold mb-3"> Judul Notulensi : {{ $notulensi->judul_notulensi }}</h1>
                    <p class="text-secondary mb-1"><strong>Notulensi :</strong></p>
                    {{-- Deskripsi dokumentasi (render dengan HTML dari TinyMCE) --}}
                    <div class="mb-4">
                        {!! $notulensi->konten_notulensi !!}
                    </div>
                    <a href="{{ route('notulensi.download', $notulensi->id_notulensi) }}" class="btn btn-primary">Download</a>   
                </div>
            </div>
    </div>
</div>
@endsection
