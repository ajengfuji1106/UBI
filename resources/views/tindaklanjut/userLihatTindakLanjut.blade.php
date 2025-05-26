@extends('partials.user.main')

@section('content')
<div class="bg-white rounded-3 p-4" style="margin-left: 260px; margin-top: 65px; height: auto; ">
    <div class="card p-4 shadow-lg border-0">
        {{-- <div> --}}
            {{-- <a href="{{ route('tindaklanjut.downloadPdf', $tindaklanjut->id_TindakLanjut) }}" class="btn btn-primary">Download</a> --}}
        {{-- </div> --}}

    <!-- Detail Tindak Lanjut -->
    <div class="card mb-4 bg-white shadow rounded-3 border-0">
        <div class="card-body">
            <h5 class="card-title">Detail Tindak Lanjut</h5>
        
            <p><strong>Judul Tindak Lanjut :</strong> {{ $tindaklanjut->judul_tugas }}</p>
        
            <p><strong>Deadline :</strong> {{ $tindaklanjut->deadline_tugas}}</p>
        
            <p><strong>Partisipan :</strong></p>
            <ul class="mb-2">
                @foreach($partisipan as $user)
                    <li>{{ $user->name }} | {{ $user->peran ?? 'Anggota' }}</li>
                @endforeach
            </ul>
        
            <p class="mb-1"><strong>Detail Tugas :</strong></p>
            {{-- Render deskripsi tugas (HTML dari TinyMCE) --}}
            <div class="mb-4">
                {!! $tindaklanjut->deskripsi_tugas !!}
            </div>
        
            <p><strong>Lampiran :</strong>
                @if($tindaklanjut->file_path)
                    <a href="{{ asset('storage/' . $tindaklanjut->file_path) }}" target="_blank" class="text-primary text-decoration-underline">Lihat Lampiran</a>
                @else
                    Tidak ada lampiran
                @endif
            </p>
        </div>
        
    </div>

    <!-- Tindak Lanjut Rapat -->
    <div class="card bg-white shadow rounded-3 border-0">
        <div class="card-body">
            <h5 class="card-title">Tindak Lanjut Rapat</h5>
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead class="table-light">
                        <tr>
                            <th scope="col">Lampiran Hasil</th>
                            <th scope="col">Catatan Revisi</th>
                            <th scope="col">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                    @php
                        $ditugaskan = $tindaklanjut->users->contains(auth()->id());
                    @endphp

                    @if($ditugaskan)
                    <tr>
                        <td colspan="3">
                            <form action="{{ route('upload.lampiran', ['id_tindaklanjut' => $tindaklanjut->id_tindaklanjut]) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="file" name="file_path" id="lampiranFile{{ $tindaklanjut->id_tindaklanjut }}" class="form-control d-none" onchange="this.form.submit()">
                            
                                <button type="button" class="btn btn-primary btn-sm" onclick="document.getElementById('lampiranFile{{ $tindaklanjut->id_tindaklanjut }}').click()">Upload Lampiran</button>
                            </form>
                        </td>
                    </tr>
                    @endif
                
                    @if ($tindaklanjut->hasil->isNotEmpty())
                        @foreach ($tindaklanjut->hasil as $hasil)
                            <tr>
                                <td>
                                    <a href="{{ asset('storage/' . $hasil->file_path) }}" target="_blank">
                                        📄 {{ $hasil->nama_file_asli ?? 'Lampiran' }}
                                    </a>
                                    <div class="small text-muted">
                                        oleh: {{ $hasil->user->name ?? '-' }} |
                                        diunggah pada: {{ $hasil->created_at->timezone('Asia/Jakarta')->format('d M Y H:i') }}
                                    </div>
                                </td>
                                <td>
                                    <a href="#" class="text-decoration-none" data-bs-toggle="modal" data-bs-target="#modalLihatRevisi-{{ $hasil->id_hasiltindaklanjut }}">
                                        Lihat di sini
                                    </a>
                                
                                    <!-- Modal Revisi -->
                                    <div class="modal fade" id="modalLihatRevisi-{{ $hasil->id_hasiltindaklanjut }}" tabindex="-1">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Catatan Revisi</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    @php
                                                        $revisi = $hasil->catatanRevisi->last();
                                                    @endphp
                                                    @if ($revisi)
                                                        <textarea class="form-control" rows="5" readonly>{{ $revisi->catatanrevisi }}</textarea>
                                                        <div class="small text-muted">
                                                            Diberikan oleh: {{ $revisi->user->name ?? '-' }}<br>
                                                            Pada: {{ $revisi->created_at->timezone('Asia/Jakarta')->format('d M Y H:i') }}
                                                        </div>
                                                    @else
                                                        <p class="text-muted">Belum ada catatan revisi.</p>
                                                    @endif
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="text-muted">{{ $hasil->status_tugas ?? '-' }}</span>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="3" class="text-muted">Belum ada file yang diunggah</td>
                        </tr>
                    @endif
                </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</div>
@endsection
