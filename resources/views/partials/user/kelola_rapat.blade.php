@extends('partials.user.main')

@section('content')
<div class="bg-white rounded-3 p-4" style="margin-left: 260px; margin-top: 75px; height: auto;">
    <div class="card p-4 shadow-lg border-0">

        {{-- Search dan Sort --}}
        <div class="d-flex justify-content-between align-items-center p-3 rounded" style="background-color: #f3f8fc;">
            <div class="position-relative w-50">
                <input id="searchInput" type="text" class="form-control ps-5" placeholder="Search..." style="border-radius: 10px; padding-left: 2.5rem;">
                <svg xmlns="http://www.w3.org/2000/svg"
                    class="position-absolute top-50 translate-middle-y"
                    style="left: 1rem;" width="16" height="16" fill="none"
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

        {{-- Tabel Rapat --}}
        <div class="table-responsive mt-3">
            <style>
                .table-striped tbody tr:nth-of-type(odd) {
                    background-color: #ffffff !important;
                }

                .table-striped tbody tr:nth-of-type(even) {
                    background-color: #f3f8fc !important;
                }

                .table thead th {
                    border-bottom: 1px solid #e6eaf0 !important;
                    background-color: #f8faff;
                }

                .table tbody td {
                    border-top: 1px solid #f0f2f5 !important;
                }

                .table tbody tr:hover {
                    background-color: #eef4fb !important;
                }
            </style>

            <table class="table table-striped align-middle">
                <thead>
                    <tr class="text-muted text-uppercase small">
                        <th>Judul Rapat</th>
                        <th>Tanggal Rapat</th>
                        <th>Jam Rapat</th>
                        <th>Lokasi Rapat</th>
                        <th>Kategori Rapat</th>
                    </tr>
                </thead>
                <tbody id="tableBody">
                    @if ($rapats->isNotEmpty())
                        @foreach ($rapats as $rapat)
                            <tr>
                                <td>
                                    <a href="{{ route('user.rapat.detail', ['id' => $rapat->id_rapat]) }}" class="fw-semibold text-primary text-decoration-underline">
                                        {{ $rapat->judul_rapat }}
                                    </a>
                                </td>
                                <td>{{ \Carbon\Carbon::parse($rapat->tanggal_rapat)->locale('id')->translatedFormat('j F Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($rapat->waktu_rapat)->format('H.i') }}</td>
                                <td>{{ $rapat->lokasi_rapat }}</td>
                                <td>{{ $rapat->kategori_rapat }}</td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="5" class="text-center text-muted">Belum ada rapat yang tersedia</td>
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

<script>
    const searchInput = document.getElementById('searchInput');
    const tableBody = document.getElementById('tableBody');

    searchInput.addEventListener('keyup', function() {
        const filter = searchInput.value.toLowerCase();
        const rows = tableBody.getElementsByTagName('tr');

        for (let i = 0; i < rows.length; i++) {
            let rowText = rows[i].textContent.toLowerCase();
            rows[i].style.display = rowText.includes(filter) ? "" : "none";
        }
    });
</script>
@endsection
