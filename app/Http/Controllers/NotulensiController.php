<?php

namespace App\Http\Controllers;

use App\Models\Rapat;
use App\Models\Notulensi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class NotulensiController extends Controller
{
    public function create($id_rapat)
    {
        if (auth()->user()->role === 'admin') {
            $layout = 'partials.admin.main';
        } else {
            $layout = 'partials.user.main';
        }
        
        return view('notulensi.buat_notulensi', compact('id_rapat', 'layout')); 
    }

    public function store(Request $request)
    {
        // Validasi input tanpa `id_user`, `created_at`, dan `updated_at`
        $validatedData = $request->validate([
            'id_rapat' => 'required|exists:rapats,id_rapat', // Sesuaikan nama tabel & kolom
            'judul_notulensi' => 'required|string|max:255',
            'konten_notulensi' => 'required',
        ]);

        // Simpan data ke database
        Notulensi::create([
            'id_rapat' => $request->id_rapat,
            'id_user' => Auth::check() ? Auth::id() : 1, // Jika belum ada auth, gunakan ID default
            'judul_notulensi' => $request->judul_notulensi,
            'konten_notulensi' => $request->konten_notulensi,
        ]);

        if (auth()->user()->role == 'admin') {
            return redirect()->route('meeting.detail', ['id' => $request->id_rapat])
                ->with('success', 'Notulensi berhasil ditambahkan.');
        } else {
            return redirect()->route('user.rapat.detail', ['id' => $request->id_rapat])
                ->with('success', 'Notulensi berhasil ditambahkan.');
        }

    }

public function show($id_notulensi)
{
    $notulensi = Notulensi::findOrFail($id_notulensi);

    if (auth()->user()->role === 'admin') {
        $layout = 'partials.admin.main';
    } else {
        $layout = 'partials.user.main';
    }
    // dd($notulensi);
    return view('notulensi.lihat_notulensi', compact('notulensi', 'layout'));
}


    // Menampilkan halaman edit
    public function edit($id_notulensi)
    {
        $notulensi = Notulensi::findOrFail($id_notulensi);
        
        if (auth()->user()->role === 'admin') {
            $layout = 'partials.admin.main';
        } else {
            $layout = 'partials.user.main';
        }
        return view('notulensi.edit_notulensi', compact('notulensi','layout'));
    }

    // Memproses update notulensi
    public function update(Request $request, $id_notulensi)
    {
        $request->validate([
            'judul_notulensi' => 'required|string|max:255',
            'konten_notulensi' => 'required|string',
        ]);

        $notulensi = Notulensi::findOrFail($id_notulensi);
        $notulensi->update([
            'judul_notulensi' => $request->judul_notulensi,
            'konten_notulensi' => $request->konten_notulensi,
        ]);

        if (auth()->user()->role == 'admin') {
            return redirect()->route('meeting.detail', ['id' => $notulensi->id_rapat])
                ->with('success', 'Notulensi berhasil diperbarui.');
        } else {
            return redirect()->route('user.rapat.detail', ['id' => $notulensi->id_rapat])
                ->with('success', 'Notulensi berhasil diperbarui.');
        }
    }

    public function destroy($id_notulensi)
    {
        $notulensi = Notulensi::findOrFail($id_notulensi);
        $notulensi->delete();
    
        if (auth()->user()->role == 'admin') {
        return redirect()->route('meeting.detail', ['id' => $notulensi->id_rapat])
            ->with('success', 'Notulensi berhasil dihapus.');
    } else {
        return redirect()->route('user.rapat.detail', ['id' => $notulensi->id_rapat])
            ->with('success', 'Notulensi berhasil dihapus.');
    }
}

public function downloadPDF($id)
{
    $notulensi = Notulensi::findOrFail($id);

    $pdf = Pdf::loadView('notulensi.notulensi_pdf', compact('notulensi'));
    return $pdf->download('notulensi_' . $notulensi->id . '.pdf');
}

}
