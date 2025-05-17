<?php
namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Rapat;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Ambil rapat mendatang yang diikuti user dari tabel peserta
        $rapats = $user->pesertas()
            ->with('rapat')
            ->whereHas('rapat', function ($query) {
                $query->whereDate('tanggal_rapat', '>=', now());
            })
            ->orderByRaw('
                (SELECT tanggal_rapat FROM rapats WHERE rapats.id_rapat = pesertas.id_rapat) ASC
            ')
            ->get()
            ->pluck('rapat');

        return view('partials.user.Dashboard', compact('rapats'));
    }
}
