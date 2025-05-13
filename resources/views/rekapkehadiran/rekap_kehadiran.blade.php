@extends('partials.admin.main')

@section('content')
<div class="bg-white rounded-3 p-4" style="margin-left: 260px; margin-top: 65px; height: auto; ">
    <div class="card p-4 shadow-lg border-0">
    <div class="d-flex justify-content-end mb-3">
        <a href="{{ route('rekap.download') }}" class="btn btn-primary">Download</a>
    </div>
    <div class="card p-3">
      <div class="table-responsive">
        <table class="table table-bordered text-center align-middle">
          <thead class="table-light">
            <tr>
              <th>Nama</th>
              <th>Kehadiran</th>
              <th>Role</th>
              <th>Bukti Kehadiran</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($pesertas as $peserta)
              <tr>
                <td>{{ $peserta->user->name }}</td>
                <td>
                  @php
                      $status = $peserta->status_kehadiran;
                      $dotClass = match($status) {
                          'hadir' => 'dot-hadir',
                          'tidak_hadir' => 'dot-tidak-hadir',
                          // 'izin' => 'dot-izin',
                          default => '',
                      };
                  @endphp
                  <span class="dot {{ $dotClass }}"></span>
                </td>
                <td>{{ $peserta->role_peserta }}</td>
                <td>
                  @if($peserta->bukti_kehadiran)
                    <a href="{{ asset('storage/' . $peserta->bukti_kehadiran) }}" target="_blank">Lihat Bukti</a>
                  @else
                    <em>Tidak ada</em>
                  @endif
                </td>
                <td>
                  <div class="dropdown">
                    <button class="btn btn-light" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                      &#8942;
                    </button>
                    {{-- <ul class="dropdown-menu action-dropdown" aria-labelledby="dropdownMenuButton"> --}}
                      {{-- <li><a class="dropdown-item" href="{{ route('peserta.edit', $peserta->id) }}">Ubah status</a></li> --}}
                      {{-- <li> --}}
                        {{-- <form action="{{ route('peserta.destroy', $peserta->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus?')"> --}}
                          {{-- @csrf --}}
                          {{-- @method('DELETE') --}}
                          {{-- <button class="dropdown-item text-danger" type="submit">Delete</button> --}}
                        {{-- </form> --}}
                      {{-- </li> --}}
                    {{-- </ul> --}}
                  </div>
                </td>
              </tr>
            @endforeach
          </tbody>
          
        </table>
      </div>
  
      <style>
        .dot {
          height: 12px;
          width: 12px;
          border-radius: 50%;
          display: inline-block;
        }
        .dot-hadir { background-color: #4CAF50; }
        .dot-tidak-hadir { background-color: #f44336; }
        .dot-izin { background-color: #ffc107; }
        .action-dropdown {
          border: 1px solid #a855f7;
          border-radius: 6px;
          color: #6b21a8;
        }
      </style>

      <div class="mt-3">
        <span><span class="dot dot-hadir"></span> Hadir</span> &nbsp;
        <span><span class="dot dot-tidak-hadir"></span> Tidak Hadir</span> &nbsp;
        {{-- <span><span class="dot dot-izin"></span> Izin</span> --}}
      </div>
    </div>
  </div>
</div>
@endsection