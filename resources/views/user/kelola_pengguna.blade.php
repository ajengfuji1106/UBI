@extends('partials.admin.main')

@section('content')
<div>
    <div class="bg-white rounded-3 p-4" style="margin-left: 260px; margin-top: 75px; height: auto; ">
            <div class="card p-4 shadow-lg border-0">

                <div class="mb-3">
                    <a href="/tambahuser" class="btn btn-primary btn-sm">
                        Tambah Pengguna
                    </a>
                </div>
            <div class="table-responsive rounded-3 overflow-hidden bg-white shadow-sm p-3 mt-3">
                <div  class="d-flex justify-content-center mb-3">
                    <input type="text" id="searchInput" class="form-control w-25" placeholder="Search">
                  </div>
        
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th scope="col" style="width: 25%">Nama</th>
                            <th scope="col" style="width: 20%">Telephone</th>
                            <th scope="col" style="width: 30%">Email</th>
                            <th scope="col" class="text-center" style="width: 10%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody  id="tableBody">
                        @if ($users->isNotEmpty())
                            @foreach ($users as $user)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <img src="{{ $user->foto ? asset('storage/' . $user->foto) :asset('assets/avatar.png') }}"
                                                class="rounded-circle object-fit-cover aspect-ratio: 1 / 1;" width="40" height="40" alt="Foto Profil">
                                            <span class="fw-semibold">{{ $user->name }}</span>
                                        </div>
                                    </td>
                                    <td>{{ $user->telephone }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-1">
                                            <a href="{{ route('user.edit', ['id' => $user->id]) }}" class="btn btn-sm btn-outline-secondary border-0">
                                                <img src="{{ asset('assets/edituser.png') }}" alt="Edit" width="16" height="16">
                                            </a>

                                            <!-- Tombol Hapus dengan Modal -->
                                            <button type="button" class="btn btn-sm btn-outline-danger border-0" data-bs-toggle="modal" data-bs-target="#hapusModal{{ $user->id }}">
                                                <img src="{{ asset('assets/delete.png') }}" alt="Hapus" width="14" height="14">
                                            </button>

                                            <!-- Modal Konfirmasi -->
                                            <div class="modal fade" id="hapusModal{{ $user->id }}" tabindex="-1" aria-labelledby="hapusModalLabel{{ $user->id }}" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Konfirmasi Hapus</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            Apakah Anda yakin ingin menghapus pengguna ini?
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                            <form action="{{ route('user.delete', ['id' => $user->id]) }}" method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-danger">Hapus</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- End Modal -->
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="4" class="text-center text-muted">Belum ada pengguna yang terdaftar</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-center mt-3">
                {{ $users->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>

<!-- Script untuk Search -->
<script>
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
