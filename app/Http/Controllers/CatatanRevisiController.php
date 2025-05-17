<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\catatanRevisi;
use Illuminate\Support\Facades\Auth;

class CatatanRevisiController extends Controller
{
    public function store(Request $request)
{
    $request->validate([
        'catatanrevisi' => 'required|string',
        'id_hasiltindaklanjut' => 'required|exists:hasil_tindak_lanjuts,id_hasiltindaklanjut',
    ]);

    catatanRevisi::create([
        'id_hasiltindaklanjut' => $request->id_hasiltindaklanjut,
        'catatanrevisi' => $request->catatanrevisi,
        'id_user' => Auth::id(),
    ]);

    return back()->with('success', 'Catatan revisi berhasil disimpan.');
}
public function update(Request $request, $id)
{
    $request->validate([
        'catatanrevisi' => 'required|string',
    ]);

    $catatan = catatanRevisi::findOrFail($id);
    $catatan->update([
        'catatanrevisi' => $request->catatanrevisi
    ]);

    return back()->with('success', 'Catatan revisi berhasil diperbarui.');
}


}
