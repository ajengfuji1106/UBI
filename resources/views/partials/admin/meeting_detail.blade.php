@extends('partials.admin.main')
@section('content')
<div class="bg-white rounded-3 p-4" style="margin-left: 260px; margin-top: 65px; height: auto; ">
    <div class="card p-5 shadow-lg border-0">
    <div class="row gx-4 align-items-start">

        <!-- Card Detail -->
        <div class="col-md-6 bg-white rounded-3 mb-4">
            <div class="card">
                <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2 class="h5 fw-semibold">Meeting Details</h2>
                <a href="{{ route('undangan.edit', $rapat->undangan->id_undangan ?? '') }}">
                    <img src="{{ asset('assets/edit.png') }}" width="16" height="16" alt="edit">
                </a>
            </div>

            @if(isset($rapat))
                <ul class="list-unstyled mb-4">
                    <li><img src="{{ asset('assets/rapat.png') }}" class="me-2" width="20"> {{ $rapat->judul_rapat }}</li>
                    <li><img src="{{ asset('assets/kalender.png') }}" class="me-2" width="20"> {{ $rapat->tanggal_rapat }}</li>
                    <li><img src="{{ asset('assets/jam.png') }}" class="me-2" width="20"> {{ $rapat->waktu_rapat }}</li>
                    <li><img src="{{ asset('assets/lokasi.png') }}" class="me-2" width="20"> {{ $rapat->lokasi_rapat }}</li>
                    <li><img src="{{ asset('assets/kategori.png') }}" class="me-2" width="20"> {{ $rapat->kategori_rapat }}</li>
                    <li>
                        <img src="{{ asset('assets/folder.png') }}" class="me-2" width="20">
                        @if(!empty($rapat->undangan->file_undangan))
                            <a href="{{ route('undangan.view', $rapat->undangan->id_undangan) }}" target="_blank">Lihat Undangan</a>
                        @else
                            <span class="text-danger">Tidak ada file undangan</span>
                        @endif
                    </li>
                </ul>
            @else
                <p class="text-danger">Belum ada undangan yang tersedia.</p>
            @endif

            <hr>
            
            {{-- partisipan --}}
            <div class="d-flex justify-content-between align-items-center mb-2">
                <h3 class="h6 fw-semibold">Partisipan ({{ $totalPeserta ?? 0 }})</h3>
                <img src="{{ asset('assets/edit.png') }}" width="16" height="16" style="cursor:pointer;" data-bs-toggle="modal" data-bs-target="#editUserModal">
            </div>

            <!-- Modal Edit Partisipan -->
            <div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                <div class="modal-content">
                
                    <div class="modal-header">
                    <h5 class="modal-title" id="editUserModalLabel">Partisipan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                
                    <div class="modal-body">
                        @if($rapat->peserta->isNotEmpty())
                            @foreach($rapat->peserta as $peserta)
                           
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span>{{ $peserta->user->name }} | {{ $peserta->role_peserta }}</span>
                                    <form action="{{ route('peserta.destroy', $peserta->id_peserta) }}" method="POST" onsubmit="return confirm('Yakin mau hapus partisipan ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-link p-0 text-danger">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            @endforeach
                        @else
                            <p class="text-muted">Belum ada partisipan yang ditambahkan.</p>
                        @endif
                    </div>
                
                    <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-success">Save</button>
                    </div>
                </div>
                </div>
            </div>
  

            <ul class="list-unstyled">
                @if($rapat->peserta->isNotEmpty())
                    @foreach($rapat->peserta as $peserta)
                        <li>{{ $peserta->user->name }} - {{ $peserta->role_peserta }}</li>
                    @endforeach
                @else
                    <li class="text-muted">Belum ada peserta</li>
                @endif
            </ul>

            <div class="mt-3">
                <a href="#" data-bs-toggle="modal" data-bs-target="#addUserModal" class="text-decoration-none">
                    <img src="{{ asset('assets/tambahpartisipan.png') }}" width="16" height="16" class="me-2">
                    Tambah Partisipan
                </a>
            </div>
        
            <!-- Modal -->
            <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                <div class="modal-content">
                

                    <form action="{{ route('peserta.store') }}" method="POST">
                        <!-- Mulai form -->
                        @csrf
                        <input type="hidden" name="id_rapat" value="{{ $id_rapat ?? '' }}">

                    <div class="modal-header">
                        <h5 class="modal-title" id="addUserModalLabel">Tambah Partisipan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                
                    <div class="modal-body">
                        {{-- Tampilkan pesan error jika ada --}}
                            @if(session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif
                        <!-- Input Nama dengan cara Select Nama-->
                        <div class="mb-3">
                            <label for="id_user" class="form-label">Nama</label>
                            <select class="form-select" id="id_user" name="id_user" required>
                                <option selected disabled value="">Pilih Nama</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option> <!-- pake ID! -->
                                @endforeach
                            </select>
                        </div>
                    
                        <!-- Select Role -->
                        <div class="mb-3">
                        <label for="role_peserta" class="form-label">Role</label>
                            <select class="form-select" id="role_peserta" name="role_peserta" required>
                            <option selected disabled value="">Pilih Role</option>
                            <option value="Moderator">Moderator</option>
                            <option value="PIC">PIC</option>
                            <option value="Anggota">Anggota</option>
                            </select>
                        </div>
                    </div>
                
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Add</button> 
                    </div>
                    </form> 
                </div>
                </div>
            </div>

            <form action="{{ route('peserta.kirimNotifikasi') }}" method="POST">
                @csrf
                <input type="hidden" name="id_rapat" value="{{ $rapat->id_rapat }}">
    
                <div class="form-check mt-3">
                    <input class="form-check-input" type="checkbox" id="notifUndangan" name="kirim_notif" value="1">
                    <label class="form-check-label" for="notifUndangan">Kirim Notifikasi Undangan</label>
                </div>
                <button class="btn btn-primary mt-2 btn-sm" type="submit">Send</button>
            </form>
            <hr>
            <div class="text-center">
                <a href="{{ route('rekap.kehadiran', ['id_rapat' => $id_rapat]) }}"><img src="{{ asset('assets/rekapkehadiran.png') }}" class="img-fluid mb-2" style="width: 100px;"></a>
                <h5 class="fw-semibold">Rekap Kehadiran</h5>
            </div>
        </div>
    </div>
</div>

        <!-- Card My Meetings -->
        <div class="col-md-6 bg-white rounded-3 text-center" style=" #EAECEE;">
            <div class="card">
                <div class="card-body">
            <div class="d-flex justify-content-between align-items-center bg-light p-3 rounded-top">
                <h2 class="h6 text-secondary fw-semibold">My Meetings</h2>

                <div class="dropdown">
                    <img src="{{ asset('assets/plus.png') }}" width="24" height="24" class="cursor-pointer" data-bs-toggle="dropdown">
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="{{ route('notulensi.create', ['id_rapat' => $rapat->id_rapat]) }}">Notulensi Rapat</a></li>
                        <li><a class="dropdown-item" href="{{ route('tindaklanjut.create', ['id_rapat' => $rapat->id_rapat]) }}">Tindak Lanjut</a></li>
                        <li><a class="dropdown-item" href="{{ route('dokumentasi.create', ['id_rapat' => $rapat->id_rapat]) }}">Dokumentasi Rapat</a></li>
                    </ul>
                </div>
            </div>

            <div class="p-4 text-start">
                @if($rapat->notulensis->count() || $rapat->tindakLanjuts->count() || $rapat->dokumentasis->count())
                    <div class="accordion" id="accordionMyMeetings">

        {{-- Notulensi --}}
        @if($rapat->notulensis->count() > 0)
        <div class="bg-white shadow-sm p-3 rounded mb-3 border">
            <h3 class="bg-primary bg-opacity-10 text-primary text-uppercase small fw-semibold px-2 py-1 rounded shadow-sm d-inline-block mb-2">Notulensi</h3>
            @foreach ($rapat->notulensis as $notulensi)
            <div class="border-top pt-2 mt-2">
                <div class="d-flex justify-content-between">
                    <div class="pe-3">
                        <p class="fw-semibold text-dark mb-1">{{ $notulensi->judul_notulensi }}</p>
                        <p class="text-muted small mb-0">{{ Str::limit(strip_tags($notulensi->konten_notulensi), 300, '...') }}</p>
                    </div>

                    {{-- view, edit, delete --}}
                    <div class="d-flex gap-1">
                        <a href="{{ route('notulensi.show', ['id_notulensi' => $notulensi->id_notulensi]) }}" title="View">
                            <img src="{{ asset('assets/eyes.png') }}" alt="View" style="width: 12px; height: 12px;">
                        </a>
                        <a href="{{ route('notulensi.edit', ['id_notulensi' => $notulensi->id_notulensi]) }}" title="Edit">
                            <img src="{{ asset('assets/edit.png') }}" alt="Edit" style="width: 11px; height: 11px;">
                        </a>
                        <form action="{{ route('notulensi.destroy', ['id_notulensi' => $notulensi->id_notulensi]) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus notulensi ini?');" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="border: none; background: none; padding: 0;" title="Delete">
                                <img src="{{ asset('assets/delete.png') }}" alt="Delete" style="width: 11px; height: 11px;">
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @endif
        
        {{-- Tindak Lanjut --}}
        @if($rapat->tindaklanjuts->count() > 0)
        <div class="bg-white shadow-sm p-3 rounded mb-3 border">
            <h3 class="bg-primary bg-opacity-10 text-primary text-uppercase small fw-semibold px-2 py-1 rounded shadow-sm d-inline-block mb-2">Tindak Lanjut</h3>
            @foreach ($rapat->tindaklanjuts as $tindaklanjut)
            <div class="border-top pt-2 mt-2">
                <div class="d-flex justify-content-between">
                    <div class="pe-3">
                        <p class="fw-semibold text-dark mb-1">{{ $tindaklanjut->judul_tugas }}</p>
                        <p class="text-muted small mb-0">{{ Str::limit(strip_tags($tindaklanjut->deskripsi_tugas), 300, '...') }}</p>
                    </div>

                    {{-- view, edit, delete --}}
                    <div class="d-flex gap-1">
                        <a href="{{ route('tindaklanjut.show', ['id_tindaklanjut' => $tindaklanjut->id_tindaklanjut]) }}" title="View">
                            <img src="{{ asset('assets/eyes.png') }}" alt="View" style="width: 12px; height: 12px;">
                        </a>
                        <a href="{{ route('tindaklanjut.edit', ['id_tindaklanjut' => $tindaklanjut->id_tindaklanjut]) }}" title="Edit">
                            <img src="{{ asset('assets/edit.png') }}" alt="Edit" style="width: 11px; height: 11px;">
                        </a>
                        <form action="{{ route('tindaklanjut.destroy', ['id_tindaklanjut' => $tindaklanjut->id_tindaklanjut]) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus tindak lanjut ini?');" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="border: none; background: none; padding: 0;" title="Delete">
                                <img src="{{ asset('assets/delete.png') }}" alt="Delete" style="width: 11px; height: 11px;">
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @endif

        {{-- Dokumentasi --}}
        @if($rapat->dokumentasis->count() > 0)
        <div class="bg-white shadow-sm p-3 rounded mb-3 border">
            <h3 class="bg-primary bg-opacity-10 text-primary text-uppercase small fw-semibold px-2 py-1 rounded shadow-sm d-inline-block mb-2">Dokumentasi</h3>
            @foreach ($rapat->dokumentasis as $dokumentasi)
            <div class="border-top pt-2 mt-2">
                <div class="d-flex justify-content-between">
                    <div class="pe-3">
                        <p class="fw-semibold text-dark mb-1">{{ $dokumentasi->judul_dokumentasi }}</p>
                        <p class="text-muted small mb-0">{{ Str::limit(strip_tags($dokumentasi->deskripsi), 300, '...') }}</p>
                    </div>

                    {{-- view, edit, delete --}}
                    <div class="d-flex gap-1">
                        <a href="{{ route('dokumentasi.show', ['id_dokumentasi' => $dokumentasi->id_dokumentasi]) }}" title="View">
                            <img src="{{ asset('assets/eyes.png') }}" alt="View" style="width: 12px; height: 12px;">
                        </a>
                        <a href="{{ route('dokumentasi.edit', ['id_dokumentasi' => $dokumentasi->id_dokumentasi]) }}" title="Edit">
                            <img src="{{ asset('assets/edit.png') }}" alt="Edit" style="width: 11px; height: 11px;">
                        </a>
                        <form action="{{ route('dokumentasi.destroy', ['id_dokumentasi' => $dokumentasi->id_dokumentasi]) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus Dokumentasi ini?');" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="border: none; background: none; padding: 0;" title="Delete">
                                <img src="{{ asset('assets/delete.png') }}" alt="Delete" style="width: 11px; height: 11px;">
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @endif
            </div>
                @else
                    <div class="text-center">
                        <img src="{{ asset('assets/book.png') }}" class="img-fluid mb-2" style="width: 100px;">
                        <p class="fw-semibold">Your meeting is empty</p>
                        <p class="text-muted small">Mulai dengan menambahkan Notulensi, Tindak Lanjut, dan Dokumentasi di sini!</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
</div>
</div>
</div>

<script>
    // Aktifkan Select2 pada dropdown
    $(document).ready(function() {
        $('#name').select2({
            placeholder: "Pilih Nama", // Placeholder jika tidak ada yang dipilih
            allowClear: true           // Mengizinkan penghapusan pilihan
        });
    });
</script>
@endsection