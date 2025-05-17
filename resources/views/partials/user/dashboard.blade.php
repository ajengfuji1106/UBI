@extends('partials.user.main')

@section('content')
<div class="bg-white rounded-3 p-4" style="margin-left: 260px; margin-top: 65px; height: auto; ">
    <div class="card p-4 shadow-lg border-0">
    <h3>Dashboard</h3>
    <div class="card mt-4">
      <div class="card-body">
        <h5 class="card-title mb-4">Jadwal Rapat Mendatang</h5>

        {{-- <div class="d-flex justify-content-between mb-3"> --}}
          {{-- <div> --}}
            {{-- <button class="btn btn-outline-secondary btn-sm">Filter</button> --}}
          {{-- </div> --}}
          {{-- <div class="d-flex"> --}}
            {{-- <input type="text" class="form-control form-control-sm me-2" placeholder="Cari..."> --}}
            {{-- <select class="form-select form-select-sm" style="width: auto;"> --}}
              {{-- <option selected>Sort by</option> --}}
              {{-- <option value="1">Tanggal</option> --}}
              {{-- <option value="2">Status</option> --}}
            {{-- </select> --}}
          {{-- </div> --}}
        {{-- </div> --}}

        <table class="table table-hover">
          <thead class="table-light">
            <tr>
              <th>Judul Rapat</th>
              <th>Tanggal Rapat</th>
              <th>Jam Rapat</th>
              <th>Lokasi Rapat</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($rapats as $rapat)
              <tr>
                <td>
                    <a href="{{ route('user.rapat.detail', ['id' => $rapat->id_rapat]) }}" class="fw-semibold text-primary text-decoration-underline">
                        {{ $rapat->judul_rapat }}
                    </a>
                </td>
                <td>{{ \Carbon\Carbon::parse($rapat->tanggal_rapat)->translatedFormat('j F Y') }}</td>
                <td>{{ \Carbon\Carbon::parse($rapat->waktu_rapat)->format('H.i') }}</td>
                <td>{{ $rapat->lokasi_rapat }}</td>
                <td>
                    @if (\Carbon\Carbon::parse($rapat->tanggal_rapat)->isFuture())
                      <span class="badge bg-warning text-dark">Belum Terlaksana</span>
                    @else
                      <span class="badge bg-success">Selesai</span>
                    @endif
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="5" class="text-center">Belum ada rapat mendatang.</td>
              </tr>
            @endforelse
          </tbody>
        </table>

      </div>
    </div>
  </div>
</div>
@endsection