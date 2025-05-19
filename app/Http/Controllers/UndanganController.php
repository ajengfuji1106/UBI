<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Rapat;
use App\Models\peserta;
use App\Models\Undangan;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UndanganController extends Controller
{

    //method untuk halaman Kelola Rapat
    public function kelolaRapat(Request $request)
    {
        $sort = $request->query('sort', 'latest'); // default: latest
        $kategori = $request->query('kategori_rapat');

        $rapatsQuery = \App\Models\Rapat::query();

        // Filter berdasarkan kategori rapat
        if ($kategori) {
            $rapatsQuery->where('kategori_rapat', $kategori);
        }
        if ($sort === 'oldest') {
            $rapatsQuery->orderBy('tanggal_rapat', 'asc');
        } else {
            $rapatsQuery->orderBy('tanggal_rapat', 'desc');
        }
        //$rapatsQuery yang sudah difilter dan disortir
        $rapats = $rapatsQuery->paginate(10); 
        // dd($rapats->toArray());
        return view('partials.admin.kelola_rapat', compact('rapats', 'sort', 'kategori'));
    }


    public function showMeetingDetail($id)
    {
        $rapat = Rapat::with('undangan')->find($id);

        if (!$rapat) {
            return redirect()->route('kelola.rapat')->with('error', 'Rapat tidak ditemukan.');
        }
    
        $users = User::all();
        return view('partials.admin.meeting_detail', compact('rapat', 'users'));
    }


    public function create()
    {
        return view('undangan.tambah_undangan');
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'judul_rapat' => 'required',
            'tanggal_rapat' => 'required|date',
            'waktu_rapat' => 'required',
            'lokasi_rapat' => 'required',
            'kategori_rapat' => 'required',
            'file_undangan' => 'required|file|mimes:pdf,doc,docx|max:2048',
        ]);


        $filePath = null; // Inisialisasi variabel
        if ($request->hasFile('file_undangan')) {
            $filePath = $request->file('file_undangan')->store('undangan', 'public');
        }

    // Simpan data rapat ke tabel rapats
    $rapat = Rapat::create([
        'judul_rapat' => $request->judul_rapat,
        'tanggal_rapat' => $request->tanggal_rapat,
        'waktu_rapat' => $request->waktu_rapat,
        'lokasi_rapat' => $request->lokasi_rapat,
        'kategori_rapat' => $request->kategori_rapat,
        'id_user' => auth()->id(),
    ]);

    // Simpan file undangan ke tabel undangans dengan referensi ke id rapat
    Undangan::create([
        'id_rapat' => $rapat->id_rapat, 
        'file_undangan' => $filePath
    ]);

    return redirect()->route('kelolarapat')->with('success', 'Undangan berhasil ditambahkan.');

    }

    //yang menangani halaman meeting detail

        public function index($id)
    {
        // Cari undangan yang terkait dengan rapat yang diklik
        $undangan = Undangan::where('id_rapat', $id)->latest()->first();

        if (!$undangan) {
            return view('partials.admin.meeting_detail', ['message' => 'Belum ada undangan yang dibuat.']);
        }

        // mengambil rapat berdasarkan ID yang diterima dari route
        $rapat = Rapat::getData($id);

         // mengambil semua ID user yang sudah menjadi peserta rapat
        $pesertaUserIds = Peserta::where('id_rapat', $id)->pluck('id_user')->toArray();

        // mengambil user yang belum jadi peserta
        $users = User::whereNotIn('id', $pesertaUserIds)->get();

        // $users = User::all();
        
        // Ambil semua peserta berdasarkan id_rapat
        $totalPeserta = Peserta::where('id_rapat', $id)->count();
        
        return view('partials.admin.meeting_detail', compact('rapat', 'undangan', 'users', 'totalPeserta',))->with('id_rapat', $id);
    }

        public function edit($id_undangan)
        {
            $undangan = Undangan::where('id_undangan', $id_undangan)->first();
        
            if (!$undangan) {
                abort(404, "Undangan dengan ID $id_undangan tidak ditemukan");
            }
        
            return view('undangan.edit_undangan', compact('undangan'));
        }
        

        // method update
        public function update(Request $request, $id_undangan)
        {
            // dd($request->all());

            $request->validate([
            'judul_rapat' => 'required',
            'tanggal_rapat' => 'required|date',
            'waktu_rapat' => 'required',
            'lokasi_rapat' => 'required',
            'kategori_rapat' => 'required',
            'file_undangan' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            ]);

            $undangan = Undangan::findOrFail($id_undangan); // mencari undangan berdasarkan ID
            $rapat = Rapat::findOrFail($undangan->id_rapat); // Ambil data rapat yang terkait


            // Cek apakah ada file yang diunggah
            if ($request->hasFile('file_undangan')) {
                // Hapus file lama jika ada
                if ($undangan->file_undangan) {
                    Storage::disk('public')->delete($undangan->file_undangan);
                }
            
                // Simpan file baru
                $filePath = $request->file('file_undangan')->store('undangan', 'public');
                $undangan->update(['file_undangan' => $filePath]);
            }
            
            Rapat::where('id_rapat', $rapat->id_rapat)->update([
                'judul_rapat' => $request->judul_rapat,
                'tanggal_rapat' => $request->tanggal_rapat,
                'waktu_rapat' => $request->waktu_rapat,
                'lokasi_rapat' => $request->lokasi_rapat,
                'kategori_rapat' => $request->kategori_rapat,
            ]);
            

            return redirect()->route('kelolarapat')->with('success', 'Undangan berhasil diperbarui.');
        }

    // hapus data rapat
    public function destroy($id_rapat)
    {
        $rapat = Rapat::where('id_rapat', $id_rapat)->firstOrFail();
        $rapat->delete();

        return redirect()->back()->with('success', 'Undangan berhasil dihapus.');
    }

    // untuk lihat file undangan
    public function viewUndangan($id)
    {
        $undangan = Undangan::findOrFail($id);

        if (!$undangan->file_undangan) {
            return abort(404, 'File undangan tidak ditemukan.');
        }

        $filePath = storage_path('app/public/' . $undangan->file_undangan);
        $fileName = Str::slug($undangan->rapat->judul_rapat, '_') . '.' . pathinfo($undangan->file_undangan, PATHINFO_EXTENSION);

        return response()->file($filePath, [
            'Content-Disposition' => 'inline; filename="' . $fileName . '"'
        ]);
    }

    // METHOD SISI user
    public function kelolaRapatUser(Request $request)
    {
        $user = Auth::user(); // dapetin user yang login

        $kategori = $request->query('kategori_rapat');
        
        $sort = $request->query('sort', 'latest'); // default: latest

        // ambil rapat yang diikuti user + sorting
        $rapatsQuery = $user->rapats();

        // Filter berdasarkan kategori rapat
        if ($kategori) {
            $rapatsQuery->where('kategori_rapat', $kategori);
        }
        //Sort by
        if ($sort === 'oldest') {
            $rapatsQuery->orderBy('tanggal_rapat', 'asc');
        } else {
            $rapatsQuery->orderBy('tanggal_rapat', 'desc');
        }

        // ambil rapat yang user ini ikuti dari tabel pesertas
        $rapats = $rapatsQuery->paginate(10); 
        // $rapats = Rapat::paginate(10); 
        return view('partials.user.kelola_rapat', compact('rapats', 'sort'));
    }


    public function showMeetingDetailUser($id)
    {
        $rapat = Rapat::with('undangan')->find($id);
    
        if (!$rapat) {
            return redirect()->route('home')->with('error', 'Rapat tidak ditemukan.');
        }
    
        $undangan = Undangan::where('id_rapat', $id)->latest()->first();
        $totalPeserta = Peserta::where('id_rapat', $id)->count();
        $user = auth()->user();

        $peserta = Peserta::where('id_rapat', $id)
        ->where('id_user', Auth::id())
        ->first();

        $pesertaUser = $rapat->peserta->where('id_user', auth()->id())->first();

        if (!$peserta) {
        return redirect()->route('user.rapat')->with('error', 'Kamu tidak memiliki akses ke rapat ini.');
        }

        $punyaakses = $peserta && in_array($peserta->role_peserta, ['Moderator', 'PIC']);
        $jikaPIC = $peserta && $peserta->role_peserta === 'PIC';

        $pesertaUserIds = Peserta::where('id_rapat', $id)->pluck('id_user')->toArray();
        $users = User::whereNotIn('id', $pesertaUserIds)->get();
        return view('partials.user.meeting_detail', compact('users', 'rapat', 'undangan', 'peserta', 'totalPeserta', 'user','punyaakses', 'jikaPIC', 'pesertaUser'))->with('id_rapat', $id);
    }
}