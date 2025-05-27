<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\TindakLanjut;
use Illuminate\Http\Request;
use App\Services\FonnteService;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\hasilTindakLanjut;
use Illuminate\Support\Facades\Storage;

class TindakLanjutController extends Controller
{
    public function create($id_rapat)
    {
        if (auth()->user()->role === 'admin') {
            $layout = 'partials.admin.main';
        } else {
            $layout = 'partials.user.main';
        }
        $users = User::whereHas('pesertas', function ($query) use ($id_rapat) {
            $query->where('id_rapat', $id_rapat);
        })->get();
        
        // $users = User::all();
        return view('tindaklanjut.buat_tindaklanjut', compact('users', 'id_rapat', 'layout'));
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'id_rapat' => 'required|exists:rapats,id_rapat',
            'id_user' => 'required|array', // Menangani input array
            'id_user.*' => 'exists:users,id', // Memastikan ID user valid
            // 'id_user' => 'required|exists:users,id',
            'judul_tugas' => 'required|string|max:255',
            'deadline_tugas' => 'required|date',
            'deskripsi_tugas' => 'required|string',
            // 'status_tugas' => 'required|in:Pending,In Progress,Completed',
            'file_path' => 'nullable|file|mimes:pdf,doc,docx|max:51200'
        ]);

        $filePath = null;
        if ($request->hasFile('file_path')) {
            $filePath = $request->file('file_path')->store('tindaklanjut_files', 'public');
        }

        $tindakLanjut = TindakLanjut::create([
        'id_rapat' => $request->id_rapat,
        // 'id_user' => auth()->id(),
        'judul_tugas' => $request->judul_tugas,
        'deadline_tugas' => $request->deadline_tugas,
        'deskripsi_tugas' => $request->deskripsi_tugas,
        'file_path' => $filePath,
    ]);

    // Assign ke banyak user lewat pivot table
    $tindakLanjut->users()->attach($request->id_user);

        // Jika checkbox dicentang, kirim notifikasi
    if ($request->has('kirim_notifikasi')) {
        foreach ($request->id_user as $userId) {
            $user = \App\Models\User::find($userId);
            if ($user && $user->telephone) {
                $this->kirimNotifikasiWhatsapp($user->telephone, $tindakLanjut, $user->name);
            }
        }
    }

        if (auth()->user()->role == 'admin') {
        return redirect()->route('meeting.detail', ['id' => $request->id_rapat])
            ->with('success', 'Tindak lanjut berhasil ditambahkan.');
    } else {
        return redirect()->route('user.rapat.detail', ['id' => $request->id_rapat])
            ->with('success', 'Tindak lanjut berhasil ditambahkan.');
    }
    
    }

    public function show($id_tindaklanjut)
    {
    $tindaklanjut = Tindaklanjut::getData($id_tindaklanjut);

    // Load relasi users dan hasil.user agar bisa diakses di Blade tanpa query tambahan
    $tindaklanjut = Tindaklanjut::with(['users', 'hasil.user'])->findOrFail($id_tindaklanjut);

    // Ambil partisipan dari relasi users
    $partisipan = $tindaklanjut->users;

    if (auth()->user()->role === 'admin') {
        $layout = 'partials.admin.main';
    } else {
        $layout = 'partials.user.main';
    }

    return view('tindaklanjut.lihat_tindaklanjut', compact('tindaklanjut', 'partisipan', 'layout')); 
    }

    // Menampilkan halaman edit
    public function edit($id_tindaklanjut)
{
    $tindaklanjut = TindakLanjut::findOrFail($id_tindaklanjut);
    // Ambil peserta rapat aja
    $users = User::whereHas('pesertas', function ($query) use ($tindaklanjut) {
        $query->where('id_rapat', $tindaklanjut->id_rapat);
    })->get();

    $assignedUserIds = $tindaklanjut->users()->pluck('users.id')->toArray(); // ambil user yang ditugasi


    if (auth()->user()->role === 'admin') {
        $layout = 'partials.admin.main';
    } else {
        $layout = 'partials.user.main';
    }

    return view('tindaklanjut.edit_tindaklanjut', [
        'tindaklanjut' => $tindaklanjut,
        'users' => $users,
        'assignedUserIds' => $assignedUserIds,
        'layout'=> $layout
    ]);
}

    // Memproses update 
    public function update(Request $request, $id_tindaklanjut)
    {
        $request->validate([
    'judul_tugas' => 'required|string|max:255',
    'deadline_tugas' => 'required|date',
    'deskripsi_tugas' => 'required|string',
    'id_user' => 'required|array',
    'id_user.*' => 'exists:users,id',
    'file_path' => 'nullable|file|mimes:pdf,doc,docx|max:51200'
    ]);

    $tindaklanjut = TindakLanjut::findOrFail($id_tindaklanjut);
    
    $filePath = $tindaklanjut->file_path;
    if ($request->hasFile('file_path')) {
        $filePath = $request->file('file_path')->store('tindaklanjut_files', 'public');
    }
    
    $tindaklanjut->update([
        'judul_tugas' => $request->judul_tugas,
        'deadline_tugas' => $request->deadline_tugas,
        'deskripsi_tugas' => $request->deskripsi_tugas,
        'file_path' => $filePath,
    ]);

    // Update user yang ditugasi
    $tindaklanjut->users()->sync($request->id_user);

    // Kirim notifikasi jika checkbox diaktifkan
    if ($request->has('kirim_notifikasi')) {
        foreach ($tindaklanjut->users as $user) {
            $this->kirimNotifikasiWhatsapp($user->telephone, $tindaklanjut, $user->name);
        }
    }

    if (auth()->user()->role == 'admin') {
        return redirect()->route('meeting.detail', ['id' => $tindaklanjut->id_rapat])
            ->with('success', 'Tindak lanjut berhasil diperbarui.');
    } else {
        return redirect()->route('user.rapat.detail', ['id' => $tindaklanjut->id_rapat])
            ->with('success', 'Tindak lanjut berhasil diperbarui.');
    }

    }

    public function destroy($id_tindaklanjut)
{
    $tindaklanjut = Tindaklanjut::findOrFail($id_tindaklanjut);

    // Hapus tindak lanjut
    $tindaklanjut->delete();

    if (auth()->user()->role == 'admin') {
    return redirect()->route('meeting.detail', ['id' => $tindaklanjut->id_rapat])
        ->with('success', 'Tindak lanjut berhasil dihapus.');
    } else {
    return redirect()->route('user.rapat.detail', ['id' => $tindaklanjut->id_rapat])
        ->with('success', 'Tindak lanjut berhasil dihapus.');
}

}
    //SISI USER
    public function showuser($id_tindaklanjut)
    {
        $tindaklanjut = Tindaklanjut::getData($id_tindaklanjut);
    
        // Ambil partisipan dari relasi users
        $partisipan = $tindaklanjut->users;
    
        // dd($notulensi);
        return view('tindaklanjut.userLihatTindakLanjut', compact('tindaklanjut', 'partisipan')); 
    }

public function uploadLampiran(Request $request, $id_tindaklanjut)
{
    $request->validate([
        'file_path' => 'required|file|mimes:pdf,doc,docx,xlsx,jpg,png|max:51200',
    ]);

    $tindaklanjut = TindakLanjut::findOrFail($id_tindaklanjut);

    $file = $request->file('file_path');

    $path = $request->file('file_path')->store('lampiran', 'public');

    // data akan disimpan ditabel hasil tindak lanjut
    $tindaklanjut->hasil()->create([
        'id_user' => auth()->id(),
        'file_path' => $path,
        'nama_file_asli' => $file->getClientOriginalName(),
        'status_tugas' => 'Menunggu Verifikasi', //default semenjara
    ]);

    return back()->with('success', 'Lampiran berhasil diunggah.');
}

public function showRevisi($id_tindaklanjut)
{
    $tindaklanjut = TindakLanjut::findOrFail($id_tindaklanjut);
    return view('tindaklanjut.revisi', compact('tindaklanjut'));
}

public function updateStatus(Request $request, $id_hasiltindaklanjut)
{
    $hasil = HasilTindakLanjut::findOrFail($id_hasiltindaklanjut);
    $hasil->status_tugas = $request->input('status_tugas');
    $hasil->save();

    return back()->with('success', 'Status tugas berhasil diperbarui.');
}


public function destroyhasiltindaklanjut($id_hasil_tindak_lanjut)
{
    // Cari hasil tindak lanjut berdasarkan ID
    $hasilTindakLanjut = HasilTindakLanjut::findOrFail($id_hasil_tindak_lanjut);

    // Hapus file terkait jika ada
    if ($hasilTindakLanjut->file_path && Storage::disk('public')->exists($hasilTindakLanjut->file_path)) {
        Storage::disk('public')->delete($hasilTindakLanjut->file_path);
    }

    // Hapus hasil tindak lanjut
    $hasilTindakLanjut->delete();

    return back()->with('success', 'Data tindak lanjut dihapus.');
}

//notif whatsapp
public function kirimNotifikasiWhatsapp($phoneNumber, $tindakLanjut, $nama = "Peserta")
{
    // Asumsikan $tindakLanjut sudah ada relasi ke rapat
    $rapat = $tindakLanjut->rapat;

    // Set locale ke bahasa Indonesia
    \Carbon\Carbon::setLocale('id');

    $judulRapat = $rapat->judul_rapat;
    $tanggal = \Carbon\Carbon::parse($rapat->tanggal_rapat)->translatedFormat('l, d F Y');
    $waktu = \Carbon\Carbon::parse($rapat->waktu_rapat)->format('H:i');
    $lokasi = $rapat->lokasi_rapat;
    $deskripsi = strip_tags($tindakLanjut->deskripsi_tugas); // buang HTML

    $message = "Halo $nama,\n"
             . "Anda mendapatkan tugas tindak lanjut dari rapat:\n"
             . "*$judulRapat*\n"
             . "🗓 $tanggal\n"
             . "⏰ Jam: $waktu\n"
             . "📍 Lokasi: $lokasi\n\n"
             . "*Judul Tugas:* {$tindakLanjut->judul_tugas}\n"
             . "📅 Deadline: " . \Carbon\Carbon::parse($tindakLanjut->deadline_tugas)->translatedFormat('l, d F Y') . "\n"
             . "📝 Deskripsi: $deskripsi\n\n"
             . "Mohon dikerjakan sebelum deadline. Terima kasih.";

    // Format nomor telepon agar hanya angka
    $phoneNumber = preg_replace('/[^0-9]/', '', $phoneNumber);

    // Kirim via FonnteService
    $fonnte = new FonnteService();
    $fonnte->sendMessage($phoneNumber, $message);
}

}
