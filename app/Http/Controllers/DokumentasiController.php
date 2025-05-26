<?php

namespace App\Http\Controllers;

use App\Models\Dokumentasi;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class DokumentasiController extends Controller
{

    /**
     * Menampilkan form tambah dokumentasi.
     */
    public function create($id_rapat)
    {
        if (auth()->user()->role === 'admin') {
            $layout = 'partials.admin.main';
        } else {
            $layout = 'partials.user.main';
        }
        return view('dokumentasi.buat_dokumentasi', compact('id_rapat','layout'));
    }

    public function store(Request $request)
{
    $request->validate([
        'id_rapat' => 'required|exists:rapats,id_rapat',
        'judul_dokumentasi' => 'required|string|max:255',
        'deskripsi' => 'nullable|string',
        // 'file_path.*' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048'
        'file_path' => 'required',
        'file_path.*' => 'image|mimes:jpg,jpeg,png|max:1024', // validasi banyak file
    ]);

    // 1. Simpan data utama dokumentasi
    $dokumentasi = Dokumentasi::create([
        'id_rapat' => $request->id_rapat,
        'judul_dokumentasi' => $request->judul_dokumentasi,
        'deskripsi' => $request->deskripsi,
    ]);

    // 2. Simpan semua file ke tabel terpisah (misalnya: file_dokumentasis)
    if ($request->hasFile('file_path')) {
        foreach ($request->file('file_path') as $file) {
            $filePath = $file->store('dokumentasi', 'public');

            \App\Models\FileDokumentasi::create([
                'id_dokumentasi' => $dokumentasi->id_dokumentasi,
                'file_path' => $filePath
            ]);
        }
    }

            if (auth()->user()->role == 'admin') {
        return redirect()->route('meeting.detail', ['id' => $request->id_rapat])
            ->with('success', 'Dokumentasi berhasil diperbarui.');
    } else {
        return redirect()->route('user.rapat.detail', ['id' => $request->id_rapat])
            ->with('success', 'Dokumentasi berhasil diperbarui.');
    }

}


public function show($id_dokumentasi)
{
    $dokumentasi = Dokumentasi::with('files')->findOrFail($id_dokumentasi);

    if (auth()->user()->role === 'admin') {
        $layout = 'partials.admin.main';
    } else {
        $layout = 'partials.user.main';
    }
    return view('dokumentasi.lihat_dokumentasi', compact('dokumentasi', 'layout'));
}

    /**
     * Menampilkan form edit dokumentasi.
     */
    public function edit($id_dokumentasi)
    {
        
        $dokumentasi = Dokumentasi::with('files')->where('id_dokumentasi', $id_dokumentasi)->firstOrFail();
        if (auth()->user()->role === 'admin') {
            $layout = 'partials.admin.main';
        } else {
            $layout = 'partials.user.main';
        }
        return view('dokumentasi.edit_dokumentasi', compact('dokumentasi', 'layout'));
    }
    
    /**
     * Memperbarui dokumentasi di database.
     */

     public function update(Request $request, $id_dokumentasi)
{
    $dokumentasi = Dokumentasi::where('id_dokumentasi', $id_dokumentasi)->firstOrFail();

    $request->validate([
        'judul_dokumentasi' => 'required|string|max:255',
        'deskripsi' => 'nullable|string',
        'file_path.*' => 'nullable|image|mimes:jpg,jpeg,png|max:1024',
        'file_path.*' => 'image|mimes:jpg,jpeg,png|max:1024', // validasi banyak file
    ]);

    // Update data utama
    $dokumentasi->update([
        'judul_dokumentasi' => $request->judul_dokumentasi,
        'deskripsi' => $request->deskripsi,
    ]);

    // Cek apakah ada file baru diupload
    if ($request->hasFile('file_path')) {
        // Hapus file lama dari storage
        foreach ($dokumentasi->files as $file) {
            Storage::disk('public')->delete($file->file_path);
            $file->delete();
        }

        // Upload file baru dan simpan ke DB
        foreach ($request->file('file_path') as $file) {
            $filePath = $file->store('dokumentasi', 'public');

            \App\Models\FileDokumentasi::create([
                'id_dokumentasi' => $dokumentasi->id_dokumentasi,
                'file_path' => $filePath
            ]);
        }
    }

        if (auth()->user()->role == 'admin') {
        return redirect()->route('meeting.detail', ['id' => $dokumentasi->id_rapat])
            ->with('success', 'Tindak lanjut berhasil diperbarui.');
    } else {
        return redirect()->route('user.rapat.detail', ['id' => $dokumentasi->id_rapat])
            ->with('success', 'Tindak lanjut berhasil diperbarui.');
    }

}
    public function destroy($id_dokumentasi)
{
    $dokumentasi = Dokumentasi::where('id_dokumentasi', $id_dokumentasi)->firstOrFail();

    // Hapus file jika ada
    if ($dokumentasi->file_path) {
        Storage::disk('public')->delete($dokumentasi->file_path);
    }

    $dokumentasi->delete();

    if (auth()->user()->role == 'admin') {
        return redirect()->route('meeting.detail', ['id' => $dokumentasi->id_rapat])
            ->with('success', 'Tindak lanjut berhasil diperbarui.');
    } else {
        return redirect()->route('user.rapat.detail', ['id' => $dokumentasi->id_rapat])
            ->with('success', 'Tindak lanjut berhasil diperbarui.');
    }

}
public function downloadPDF($id)
{
    $dokumentasi = Dokumentasi::with('files')->findOrFail($id);
    
    $pdf = Pdf::loadView('dokumentasi.dokumentasi_pdf', compact('dokumentasi'));

    return $pdf->download('dokumentasi_' . $dokumentasi->id_dokumentasi . '.pdf');
}

}
