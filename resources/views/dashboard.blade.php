@extends('partials.admin.main')

@section('content')
<div class="bg-white rounded-3 p-4" style="margin-left: 260px; margin-top: 65px; height: auto; ">
    <div class="card p-4 shadow-lg border-0">
    <h3>Dashboard</h3>
    <div class="card mt-4">
      <div class="card-body">
        <h5 class="card-title mb-4">Rapat Mendatang</h5>

        <div class="d-flex justify-content-between mb-3">
          <button class="btn btn-outline-secondary btn-sm">
              <i class="bi bi-funnel"></i> Filter
          </button>
          <div class="d-flex">
            <input type="text" class="form-control form-control-sm me-2" placeholder="Cari...">
            <select class="form-select form-select-sm" style="width: auto;">
              <option selected>Sort by</option>
              <option value="1">Tanggal</option>
              <option value="2">Status</option>
            </select>
          </div>
        </div>

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
            <tr>
              <td>Koordinasi Dekan</td>
              <td>5 Desember 2024</td>
              <td>10.30</td>
              <td>Ruang Rapat Rektorat</td>
              <td><span class="status-badge">Belum Terlaksana</span></td>
            </tr>
            <tr>
              <td>Gladi Resik Wisuda</td>
              <td>23 November 2024</td>
              <td>12.30</td>
              <td>Hotel Aston Banyuwangi</td>
              <td><span class="status-badge">Belum Terlaksana</span></td>
            </tr>
            <tr>
              <td>Sosialisasi Akademik</td>
              <td>15 November 2024</td>
              <td>10.00</td>
              <td>Zoom Workplace</td>
              <td><span class="status-badge">Belum Terlaksana</span></td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection