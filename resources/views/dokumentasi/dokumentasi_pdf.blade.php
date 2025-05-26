<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Dokumentasi PDF</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        .image { margin: 10px 0; max-height: 300px; }

        .kop-surat {
            display: flex;
            align-items: center;
            /* border-bottom: 3px solid black; */
            /* padding-bottom: 5px; */
            /* margin-bottom: 10px; */
        }
        .kop-surat img {
            width: 100px;
            margin: -35px;
            /* margin-right: 20px; */
        }
        .kop-teks {
            flex: 1;
            text-align: center;
            padding: 0;
            margin: 0;
        }
        .kop-teks h1 {
            margin: -35px ;
            margin-bottom: 5px;
            font-size: 22px;
            font-weight: bold;
            line-height: 1.1;
        }
        .kop-teks p {
            margin: 1px 0;
            line-height: 1.1; 
        }
        .kop-teks h3 { 
            margin: 0; 
            font-size: 18px; 
            line-height: 1.1;
        }
        .alamat {
        font-size: 10px;
        border-top: 2px solid black;
        border-bottom: 2px solid black;
        padding: 4px 0;
        text-align: center;
        }
        hr {
            border: 1px solid black;
            margin: 5px 0;
        }
    </style>
</head>
<body>
    <div class="kop-surat">
    <img src="{{ public_path('logoubi.png') }}" alt="Logo Universitas Bakti Indonesia"> 
    <div class="kop-teks">
        <h1>UNIVERSITAS BAKTI INDONESIA</h1>
        <h3>BANYUWANGI</h3>
        <p>IJIN SK MENDIKNAS : 32/D/O/2009</p>
        <p>
            1. Fakultas Kesehatan Masyarakat &nbsp;
            2. Fakultas Ilmu Kesehatan &nbsp;
            3. Fakultas Hukum &nbsp;
            4. Fakultas Ekonomi <br>
            5. Fakultas Teknik &nbsp;
            6. Fakultas Bahasa &nbsp;
            7. Fakultas MIPA &nbsp;
            8. F Keguruan Ilmu Pendidikan <br>
            9. Fakultas Ilmu Keolahragaan &nbsp;
            10. Program Pascasarjana
        </p>
        <div class="alamat">
            (Kawasan Kampus Terpadu) Bumi Cempokosari No.40 Cluring, Banyuwangi (68482); Telp & Fax : 0333-3912341; Email : office@ubibanyuwangi.ac.id
        </div>
    </div>
</div>
    <h4>Judul Dokumentasi: {{ $dokumentasi->judul_dokumentasi }}</h4>
    @if (!empty($dokumentasi->deskripsi))
        <p class="text-secondary mb-1"><strong>Deskripsi:</strong></p>
        {{-- Deskripsi dokumentasi (render dengan HTML dari TinyMCE) --}}
        <div class="mb-4">
            {!! $dokumentasi->deskripsi !!}
        </div>
    @endif

    @if ($dokumentasi->files->isNotEmpty())
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
