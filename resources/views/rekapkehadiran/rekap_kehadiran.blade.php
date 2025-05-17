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
                      <a href="#" data-bs-toggle="modal" data-bs-target="#modalBukti{{ $peserta->id_peserta }}">
                        Lihat Bukti
                      </a>
                    
                      <!-- Modal untuk preview gambar -->
                      <div class="modal fade" id="modalBukti{{ $peserta->id_peserta }}" tabindex="-1" aria-labelledby="modalBuktiLabel{{ $peserta->id_peserta }}" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="modalBuktiLabel{{ $peserta->id_peserta }}">Bukti Kehadiran</h5>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                            </div>
                            <div class="modal-body text-center">
                              <img src="{{ asset('storage/' . $peserta->bukti_kehadiran) }}" alt="Bukti Kehadiran" class="img-fluid rounded">
                            </div>
                          </div>
                        </div>
                      </div>
                    @else
                      <em>Tidak ada</em>
                    @endif
                </td>
                <td>
                <div class="dropdown">
                  <button class="btn btn-light" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                    &#8942;
                  </button>
                  <ul class="dropdown-menu action-dropdown" aria-labelledby="dropdownMenuButton">
                    <li class="dropdown-submenu">
                      <a class="dropdown-item dropdown-toggle" href="#">Ubah status</a>
                      <ul class="dropdown-menu">
                        <li>
                          <form action="{{ route('peserta.updateStatus', [$peserta->id_peserta, 'hadir']) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <button class="dropdown-item" type="submit">Hadir</button>
                          </form>
                        </li>
                        <li>
                          <form action="{{ route('peserta.updateStatus', [$peserta->id_peserta, 'tidak_hadir']) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <button class="dropdown-item" type="submit">Tidak Hadir</button>
                          </form>
                        </li>
                      </ul>
                    </li>
                    <li>
                      <form action="{{ route('peserta.destroy', $peserta->id_peserta) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus?')">
                        @csrf
                        @method('DELETE')
                        <button class="dropdown-item text-danger" type="submit">Delete</button>
                      </form>
                    </li>
                  </ul>
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

        .dropdown-submenu {
          position: relative;
        }

        .dropdown-submenu > .dropdown-menu {
          top: 0;
          right: 100%;
          margin-top: -1px;
          margin-right: 4px;
          display: none;
          position: absolute;
          transform: translateX(-8px);
        }

        .dropdown-submenu.show > .dropdown-menu {
          display: block;
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

<script>
  document.addEventListener('DOMContentLoaded', function () {
    // Toggle tampil submenu saat klik
    document.querySelectorAll('.dropdown-submenu > a').forEach(function (trigger) {
      trigger.addEventListener('click', function (e) {
        e.preventDefault(); // Biar gak redirect ke href
        e.stopPropagation(); // Biar dropdown utama gak ketutup
        const parent = this.parentElement;

        // Tutup semua submenu lain dulu
        document.querySelectorAll('.dropdown-submenu').forEach(function (el) {
          if (el !== parent) el.classList.remove('show');
        });

        // Toggle submenu yang diklik
        parent.classList.toggle('show');
      });
    });

    // Cegah form di submenu nutupin dropdown
    document.querySelectorAll('.dropdown-submenu form').forEach(function (form) {
      form.addEventListener('click', function (e) {
        e.stopPropagation();
      });
    });

    // Tutup semua submenu kalau klik di luar
    document.addEventListener('click', function () {
      document.querySelectorAll('.dropdown-submenu').forEach(function (el) {
        el.classList.remove('show');
      });
    });
  });
</script>

@endsection