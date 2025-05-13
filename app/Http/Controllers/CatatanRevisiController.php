<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\catatanRevisi;

class CatatanRevisiController extends Controller
{
    public function store(Request $request)
{
    $request->validate([
        'catatanrevisi' => 'required|string',
        'id_tindak_lanjut_user' => 'required|exists:tindak_lanjut_user,id'
    ]);

    catatanRevisi::create([
        'id_tindak_lanjut_user' => $request->id_tindak_lanjut_user,
        'catatanrevisi' => $request->catatanrevisi
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
