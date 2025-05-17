@extends($layout)

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
        
            <p class="text-secondary mb-1"><strong>Detail Tugas:</strong></p>
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
                            <th scope="col">Diunggah Oleh</th>
                            <th scope="col">Catatan Revisi</th>
                            <th scope="col">Status</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($tindaklanjut->hasil as $hasil)
                            <tr>
                                <td>
                                    <a href="{{ asset('storage/' . $hasil->file_path) }}" target="_blank">
                                        {{ $hasil->nama_file_asli ?? 'File Lampiran' }}
                                    </a>
                                    <div class="small text-muted"> diunggah pada: {{ $hasil->created_at->timezone('Asia/Jakarta')->format('d M Y H:i') }} </div>
                                </td>
                                <td>{{ $hasil->user->name ?? 'User tidak ditemukan' }}</td>
                                <td>
                                    <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modalRevisi-{{ $hasil->id_hasiltindaklanjut }}">
                                        Catatan Revisi
                                    </button>
                                
                                    <!-- Modal -->
                                    <div class="modal fade" id="modalRevisi-{{ $hasil->id_hasiltindaklanjut }}" tabindex="-1">
                                        <div class="modal-dialog">
                                            <form action="{{ route('catatan-revisi.store') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="id_hasiltindaklanjut" value="{{ $hasil->id_hasiltindaklanjut }}">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Catatan Revisi</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        @php
                                                            $revisiTerakhir = $hasil->catatanRevisi->last();
                                                        @endphp

                                                        @if ($revisiTerakhir)
                                                            <label class="form-label">Catatan Sebelumnya:</label>
                                                            <textarea class="form-control mb-3" rows="4" readonly>{{ $revisiTerakhir->catatanrevisi }}</textarea>
                                                            <div class="text-muted small">
                                                                Diberikan oleh: {{ $revisiTerakhir->user->name ?? '-' }} <br>
                                                                Pada: {{ $revisiTerakhir->created_at->timezone('Asia/Jakarta')->format('d M Y H:i') }}
                                                            </div>
                                                        @endif
                                                    <br>
                                                        <label class="form-label">Tulis Catatan Baru:</label>
                                                        <textarea name="catatanrevisi" class="form-control" rows="5" placeholder="Tulis catatan revisi..."></textarea>
                                                    </div>
                                                
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-primary">Kirim</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <form action="{{ route('tindaklanjut.updateStatus', $hasil->id_hasiltindaklanjut) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <select name="status_tugas" class="form-select form-select-sm" onchange="this.form.submit()">
                                            <option value="Revisi" {{ $hasil->status_tugas == 'Revisi' ? 'selected' : '' }}>Revisi</option>
                                            <option value="Selesai" {{ $hasil->status_tugas == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                                            <option value="Sedang Ditinjau" {{ $hasil->status_tugas == 'Sedang Ditinjau' ? 'selected' : '' }}>Sedang Ditinjau</option>
                                        </select>
                                    </form>
                                </td>
                                <td>
                                     <form action="{{ route('hasil-tindaklanjut.destroy', $hasil->id_hasiltindaklanjut) }}" method="POST" class="d-inline">
                                         @csrf
                                         @method('DELETE')
                                         <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Hapus data ini?')">Hapus</button>
                                     </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted">Belum ada hasil yang diunggah</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
</div>
</div>
@endsection
