<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Dokumentasi PDF</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        .image { margin: 10px 0; max-height: 300px; }
    </style>
</head>
<body>
    <h2>Judul Dokumentasi: {{ $dokumentasi->judul_dokumentasi }}</h2>
    <p>Deskripsi: {!! $dokumentasi->deskripsi !!}</p>

    @if ($dokumentasi->files->isNotEmpty())
        <h4>Dokumentasi File:</h4>
        @foreach ($dokumentasi->files as $file)
            @if (Str::endsWith($file->file_path, ['jpg', 'jpeg', 'png']))
                <img src="{{ public_path('storage/' . $file->file_path) }}" class="image">
            @else
                <p>File: {{ $file->file_path }}</p>
            @endif
        @endforeach
    @endif
</body>
</html>
