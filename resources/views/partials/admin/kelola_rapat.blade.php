@extends('partials.admin.main')

@section('content')
    <div class="bg-white rounded-3 p-4" style="margin-left: 260px; margin-top: 75px; height: auto; ">
            <div class="card p-4 shadow-lg border-0">

                {{-- Tombol Tambah --}}
                <div class="d-flex justify-content-start mb-3">
                    <a href="/tambahundangan" class="btn btn-primary btn-sm">Tambah Rapat</a>
                </div>

                {{-- Filter, Search, Sort --}}
                <div class="d-flex justify-content-between align-items-center p-3 rounded" style="background-color: #f3f8fc;">
                    <div>
                        <button class="btn btn-outline-secondary d-flex align-items-center gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-.293.707L15 14.414V19a1 1 0 01-.553.894l-4 2A1 1 0 019 21v-6.586L3.293 6.707A1 1 0 013 6V4z" />
                            </svg>
                            Filter <span class="badge bg-primary">2</span>
                        </button>
                    </div>
                    <div class="position-relative w-50">
                        <input id="searchInput" type="text" class="form-control ps-5" placeholder="Search..." style="border-radius: 10px; padding-left: 2.5rem;">
                        <svg xmlns="http://www.w3.org/2000/svg"
                             class="position-absolute top-50 translate-middle-y"
                             style="left: 1rem;"
                             width="16" height="16" fill="none"
                             viewBox="0 0 24 24" stroke="gray">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M10 18a8 8 0 100-16 8 8 0 000 16zM21 21l-4.35-4.35" />
                        </svg>
                    </div>
                
                    <div class="d-flex align-items-center">
                        <label class="me-2 mb-0">Sort by:</label>
                        <select class="form-select form-select-sm" style="width: 100px;">
                            <option>Oldest</option>
                            <option>Latest</option>
                        </select>
                    </div>
                </div>

                @if (session('message'))
                    <div class="alert alert-warning mt-3">
                        {{ session('message') }}
                    </div>
                @endif

                {{-- Table --}}
                <div class="table-responsive mt-3">
                    <style>
                        /* Warna latar zebra stripe (putih dan biru sangat terang) */
                        .table-striped tbody tr:nth-of-type(odd) {
                            background-color: #ffffff !important;
                        }
                    
                        .table-striped tbody tr:nth-of-type(even) {
                            background-color: #f3f8fc !important;
                        }
                    
                        /* Bikin border lembut seperti di desain */
                        .table {
                            border-collapse: separate;
                            border-spacing: 0;
                        }
                    
                        .table thead th {
                            border-bottom: 1px solid #e6eaf0 !important;
                            background-color: #f8faff;
                        }
                    
                        .table tbody td {
                            border-top: 1px solid #f0f2f5 !important;
                        }
                    
                        /* Hapus border samping untuk kesan minimal */
                        .table thead th:first-child,
                        .table tbody td:first-child {
                            border-left: none !important;
                        }
                    
                        .table thead th:last-child,
                        .table tbody td:last-child {
                            border-right: none !important;
                        }
                    
                        /* Tambahan: kasih radius halus di baris (optional aesthetic) */
                        .table tbody tr {
                            border-radius: 10px;
                            overflow: hidden;
                        }
                    
                        /* Hover effect lembut */
                        .table tbody tr:hover {
                            background-color: #eef4fb !important;
                        }
                    </style>
                    
                    
                    <table class="table table-striped align-middle">
                        <thead style="background-color: #f8faff;">
                            <tr class="text-muted text-uppercase small">
                                <th>Judul Rapat</th>
                                <th>Tanggal Rapat</th>
                                <th>Jam Rapat</th>
                                <th>Lokasi Rapat</th>
                                <th>Kategori Rapat</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="tableBody">
                            @if ($rapats->isNotEmpty())
                                @foreach ($rapats as $rapat)
                                    <tr class="border-top">
                                        <td>
                                            <a href="{{ route('meeting.detail', ['id' => $rapat->id_rapat]) }}" class="fw-semibold text-primary text-decoration-underline">
                                                {{ $rapat->judul_rapat }}
                                            </a>
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($rapat->tanggal_rapat)->locale('id')->translatedFormat('j F Y') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($rapat->waktu_rapat)->format('H.i') }}</td>
                                        <td>{{ $rapat->lokasi_rapat }}</td>
                                        <td>{{ $rapat->kategori_rapat }}</td>
                                        <td>
                                            <!-- Tombol Hapus -->
                                            <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $rapat->id_rapat }}">
                                                Hapus
                                            </button>

                                            <!-- Modal -->
                                            <div class="modal fade" id="deleteModal{{ $rapat->id_rapat }}" tabindex="-1" aria-labelledby="modalLabel{{ $rapat->id_rapat }}" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="modalLabel{{ $rapat->id_rapat }}">Konfirmasi Hapus</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            Apakah Anda yakin ingin menghapus undangan ini?
                                                        </div>
                                                        <div class="modal-footer">
                                                            <form action="{{ route('rapat.delete', ['id_rapat' => $rapat->id_rapat]) }}" method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                                <button type="submit" class="btn btn-danger">Hapus</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="6" class="text-center text-muted">Belum ada undangan yang dibuat</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-center mt-3">
                    <div>
                        {{ $rapats->links('pagination::bootstrap-5') }}
                    </div> 
                </div>
            </div>
        </div>
    </div>

    <script>

        //script untuk fitur seacrh
        const searchInput = document.getElementById('searchInput');
        const tableBody = document.getElementById('tableBody');
    
        searchInput.addEventListener('keyup', function() {
            const filter = searchInput.value.toLowerCase();
            const rows = tableBody.getElementsByTagName('tr');
    
            for (let i = 0; i < rows.length; i++) {
                let rowText = rows[i].textContent.toLowerCase();
                if (rowText.indexOf(filter) > -1) {
                    rows[i].style.display = "";
                } else {
                    rows[i].style.display = "none";
                }
            }
        });
    </script>
    
@endsection
