@extends('partials.admin.main')

@section('content')
<div class="bg-white rounded-3 p-4" style="margin-left: 260px; margin-top: 65px; height: auto;">
  <div class="card p-4 shadow-lg border-0">
    <h3>Dashboard</h3>

    <div class="card mt-4">
      <div class="card-body">
        <h5 class="card-title mb-4">Jadwal Rapat Mendatang</h5>

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
            @foreach ($rapats as $rapat)
              <tr>
                <td>
                  <a href="{{ route('meeting.detail', ['id' => $rapat->id_rapat]) }}"
                    class="fw-semibold text-primary text-decoration-underline">
                    {{ $rapat->judul_rapat }}
                  </a>
                </td>
                <td>{{ \Carbon\Carbon::parse($rapat->tanggal_rapat)->locale('id')->translatedFormat('j F Y') }}</td>
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
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection
