<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Rekap Kehadiran</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }
        .dot {
            height: 10px;
            width: 10px;
            border-radius: 50%;
            display: inline-block;
        }
        .dot-hadir { background-color: #4CAF50; }
        .dot-tidak-hadir { background-color: #f44336; }
        .dot-izin { background-color: #ffc107; }
    </style>
</head>
<body>
    <h2>Rekap Kehadiran</h2>
    <table>
        <thead>
            <tr>
                <th>Nama</th>
                <th>Kehadiran</th>
                <th>Role</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pesertas as $peserta)
            <tr>
                <td>{{ $peserta->nama }}</td>
                <td>
                    @if($peserta->status_kehadiran == 'hadir')
                        <span class="dot dot-hadir"></span>
                    @elseif($peserta->status_kehadiran == 'tidak_hadir')
                        <span class="dot dot-tidak-hadir"></span>
                    @elseif($peserta->status_kehadiran == 'izin')
                        <span class="dot dot-izin"></span>
                    @endif
                </td>
                <td>{{ $peserta->role }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
