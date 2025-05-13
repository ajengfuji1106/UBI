<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>PDF Tindak Lanjut</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        h5 { margin-bottom: 10px; }
        ul { margin: 0; padding-left: 20px; }
        table, th, td { border: 1px solid black; border-collapse: collapse; }
        th, td { padding: 5px; text-align: left; }
    </style>
</head>
<body>
    <h5>Detail Tindak Lanjut</h5>
    <p><strong>Judul Tindak Lanjut:</strong> {{ $tindaklanjut->judul_tugas }}</p>
    <p><strong>Deadline:</strong> {{ \Carbon\Carbon::parse($tindaklanjut->deadline_tugas)->translatedFormat('d F Y') }}</p>

    <p><strong>Partisipan:</strong></p>
    <ul>
        @foreach($partisipan as $user)
            <li>{{ $user->name }} | {{ $user->peran ?? 'Anggota' }}</li>
        @endforeach
    </ul>

    <p><strong>Detail Tugas:</strong></p>
    <ul>
        @php
            $details = preg_split('/\r\n|\r|\n/', $tindaklanjut->deskripsi_tugas);
        @endphp
        @foreach($details as $detail)
            @if(trim($detail) !== '')
                <li>{{ $detail }}</li>
            @endif
        @endforeach
    </ul>

    <p><strong>Lampiran:</strong>
        {{ $tindaklanjut->file_path ? 'Ada Lampiran' : 'Tidak ada lampiran' }}
    </p>
</body>
</html>
