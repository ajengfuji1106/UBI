<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Rapat;
use App\Models\Peserta;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class PesertaController extends Controller
{
    // public function index($id_rapat)
    // {
        // $peserta = Peserta::where('id_rapat', $id_rapat)->get();
        // $roles = ['Moderator', 'PIC Rapat', 'Anggota Rapat'];
        // return view('peserta.index', compact('peserta', 'roles'));
        // $peserta = Peserta::where('id_rapat', $id_rapat)->with('user')->get();
        // $users = User::all(); // Ambil semua user untuk pilihan di modal
        // $roles = ['Moderator', 'PIC Rapat', 'Anggota Rapat'];

        // return view('peserta.index', compact('peserta', 'roles', 'users'));
    // }
// Menampilkan form tambah partisipan
public function create($id_rapat)
{
    return view('peserta.create', compact('id_rapat'));
}

// Menyimpan data partisipan baru
public function store(Request $request)
{
    // dd($request->all());
    // Validasi input
    $request->validate([
        'id_rapat' => 'required|exists:rapats,id_rapat',
        'id_user' => 'required|exists:users,id',
        'role_peserta' => 'required|string',
    ]);

    // Cek apakah role yang mau ditambahkan sudah ada sebelumnya
    if (in_array($request->role_peserta, ['Moderator'])) {
        $existing = Peserta::where('id_rapat', $request->id_rapat)
            ->where('role_peserta', $request->role_peserta)
            ->first();

        if ($existing) {
            return redirect()->back()->with('error', 'Sudah ada ' . $request->role_peserta . ' untuk rapat ini.');
        }
    }

    // Simpan data peserta
    Peserta::create([
        'id_rapat' => $request->id_rapat,
        'id_user' => $request->id_user,
        'role_peserta' => $request->role_peserta,
        'status_kehadiran' => null,  // Status kehadiran bisa kosong atau diatur nanti
    ]);

    // Redirect setelah sukses
    return redirect()->route('meeting.detail', ['id' => $request->id_rapat])
    ->with('success', 'Notulensi berhasil ditambahkan!');
}

public function show($id) {
    $rapat = Rapat::find($id);
    if (!$rapat) {
        abort(404, "Rapat tidak ditemukan");
    }

    
    // Kirimkan id_rapat ke view
    $id_rapat = $rapat->id;
    return view('meeting.detail', compact('rapat', 'id_rapat'));
}


// Menampilkan form edit data partisipan
public function edit($id_peserta)
{
    $peserta = Peserta::findOrFail($id_peserta);  // Pastikan peserta ditemukan
    $users = User::all();  // Ambil semua user
    $rapat = Rapat::findOrFail($peserta->id_rapat);  // Ambil rapat yang terkait

    return view('peserta.edit', compact('peserta', 'users', 'rapat'));
}

// Menyimpan perubahan data partisipan
public function update(Request $request, $id_peserta)
{
    // Validasi input
    $request->validate([
        'id_user' => 'required|exists:users,id',
        'role_peserta' => 'required|string',
    ]);

    // Cari peserta berdasarkan id
    $peserta = Peserta::findOrFail($id_peserta);

    // Update data peserta
    $peserta->update([
        'id_user' => $request->id_user,
        'role_peserta' => $request->role_peserta,
        'status_kehadiran' => $request->status_kehadiran, // Jika ada field status_kehadiran
    ]);

    // Redirect setelah sukses
    return redirect()->route('peserta.index', $peserta->id_rapat)->with('success', 'Partisipan berhasil diperbarui!');
}

// Menghapus data partisipan
public function destroy($id_peserta)
{
    // Cari peserta berdasarkan id
    $peserta = Peserta::findOrFail($id_peserta);

    // Hapus peserta
    $peserta->delete();

    // Redirect setelah sukses
return redirect()->route('meeting.detail', ['id' => $peserta->id_rapat])
    ->with('success', 'Partisipan berhasil dihapus!');
}

//rekap kehadiran
public function rekap($id_rapat)
    {
        $pesertas = Peserta::with('user') // Mengambil relasi user untuk mendapatkan nama
                       ->where('id_rapat', $id_rapat) // Filter berdasarkan rapat
                       ->get();
        return view('rekapkehadiran.rekap_kehadiran', compact('pesertas'));
    }

//download rekap kehadiran
public function downloadRekap()
{
    $pesertas = Peserta::all(); // Ambil semua peserta (ubah kalau mau filter)

    $pdf = Pdf::loadView('rekapkehadiran.rekapkehadiran_pdf', compact('pesertas'));

    return $pdf->download('rekap_kehadiran.pdf');
}

public function konfirmasiKehadiran(Request $request, $id_peserta)
{
    // dd($id_peserta, $request->all());
    $peserta = Peserta::findOrFail($id_peserta);

    // Cegah konfirmasi ulang
    if ($peserta->status_kehadiran) {
        return redirect()->back()->with('error', 'Kehadiran sudah dikonfirmasi. Tidak bisa mengubah lagi.');
    }

    // dd($request->all());
    // Validasi status
    $request->validate([
        'status_kehadiran' => 'required|in:hadir,tidak_hadir',
        'bukti_kehadiran' => 'nullable|image|max:2048', // jika pakai upload
    ]);

    // Simpan file jika ada
    if ($request->hasFile('bukti_kehadiran')) {
        $path = $request->file('bukti_kehadiran')->store('bukti_kehadiran', 'public');
        $peserta->bukti_kehadiran = $path;
    }

    $peserta->status_kehadiran = $request->status_kehadiran;
    $peserta->save();

    return back()->with('success', 'Kehadiran berhasil dikonfirmasi!');
}
}