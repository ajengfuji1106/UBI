<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Peserta;
use App\Models\Notulensi;
use App\Models\TindakLanjut;
use App\Models\Dokumentasi;

class  CheckMeetingRole
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // admin punya hak akses penuh
        if (auth()->user()->role === 'admin') {
            return $next($request);
        }

      
        $meetingId = $request->route('id_rapat');

        
        if (!$meetingId) {
            if ($request->route('id_notulensi')) {
                $notulensi = Notulensi::find($request->route('id_notulensi'));
                $meetingId = $notulensi?->id_rapat;
            } elseif ($request->route('id_tindaklanjut')) {
                $tindaklanjut = TindakLanjut::find($request->route('id_tindaklanjut'));
                $meetingId = $tindaklanjut?->id_rapat;
            } elseif ($request->route('id_dokumentasi')) {
                $dokumentasi = Dokumentasi::find($request->route('id_dokumentasi'));
                $meetingId = $dokumentasi?->id_rapat;
            }
        }

        // Kalau tetap tidak dapat ID rapat
        if (!$meetingId) {
            abort(403, 'ID rapat tidak ditemukan dari route.');
        }

        // Ambil role user di rapat tersebut
        $userRole = Peserta::where('id_rapat', $meetingId)
                           ->where('id_user', auth()->id())
                           ->value('role_peserta');

        // Kalau role-nya ga cocok
        if (!in_array($userRole, $roles)) {
            abort(403, 'Akses ditolak. Anda bukan ' . implode(" atau ", $roles));
        }

        return $next($request);
    }
}
