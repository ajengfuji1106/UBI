<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Notulensi</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <h2>Judul Notulensi: {{ $notulensi->judul_notulensi }}</h2>
    <div>
        {!! $notulensi->konten_notulensi !!}
    </div>
</body>
</html>
