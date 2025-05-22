<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Rekap Kehadiran</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 5px; text-align: center; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h3>Rekap Kehadiran - {{ $rapat->nama_rapat }}</h3>
    <p>Tanggal: {{ \Carbon\Carbon::parse($rapat->tanggal_rapat)->format('d M Y') }}</p>

    <table>
        <thead>
            <tr>
                <th>Nama</th>
                <th>Kehadiran</th>
                <th>Role</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pesertas as $peserta)
            <tr>
                <td>{{ $peserta->user->name }}</td>
                <td>{{ ucfirst(str_replace('_', ' ', $peserta->status_kehadiran)) }}</td>
                <td>{{ $peserta->role_peserta }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
