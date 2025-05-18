<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Middleware\CheckMeetingRole;
use App\Http\Controllers\PesertaController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UndanganController;
use App\Http\Controllers\NotulensiController;
use App\Http\Controllers\DokumentasiController;
use App\Http\Controllers\TindakLanjutController;
use App\Http\Controllers\CatatanRevisiController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\User\DashboardController;


Route::get('/', function () {
    return view('auth.login');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])
        ->name('admin.dashboard');

    Route::get('/user/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('user.dashboard');
});


Route::middleware('auth')->group(function () {
    //profile
Route::get('/profile', [UserController::class, 'profile'])->name('profile');
Route::get('/profile/edit', [UserController::class, 'editProfile'])->name('profile.edit');
Route::put('/profile/update', [UserController::class, 'updateProfile'])->name('profile.update');
Route::get('/profile', [UserController::class, 'show'])->name('profile.show');
Route::get('/profile/password', [UserController::class, 'editPassword'])->name('profile.password');
Route::put('/profile/password/update', [UserController::class, 'updatePassword'])->name('profile.password.update');
});

require __DIR__.'/auth.php';



// undangan
Route::get('/tambahundangan', [UndanganController::class, 'create'])
    ->name('undangan.create');

Route::get('/kelolarapat', [UndanganController::class, 'kelolaRapat'])
    ->name('kelolarapat');

Route::post('/undangan', [UndanganController::class, 'store'])
    ->name('undangan.store');

Route::get('/meetingdetail/{id}', [UndanganController::class, 'index'])
    ->name('meeting.detail');

Route::get('/meeting/{id}/detail', [UndanganController::class, 'showMeetingDetail'])
    ->name('undangan.detail');

//lihat dan download undangan
Route::get('/undangan/view/{id}', [UndanganController::class, 'viewUndangan'])
    ->name('undangan.view');

//edit undangan
Route::get('/undangan/{id_undangan}/edit', [UndanganController::class, 'edit'])
    ->name('undangan.edit');

Route::put('/undangan/{id_undangan}', [UndanganController::class, 'update'])
    ->name('undangan.update');

Route::delete('/rapat/{id_rapat}', [UndanganController::class, 'destroy'])
    ->name('rapat.delete');

// PESERTA
Route::get('/tambahpeserta/{id_rapat}', [PesertaController::class, 'create'])
    ->middleware('CheckMeetingRole:PIC')
    ->name('peserta.create');

Route::post('peserta/store', [PesertaController::class, 'store'])
    ->name('peserta.store');

Route::get('peserta/{id_peserta}/edit', [PesertaController::class, 'edit'])
    ->middleware('CheckMeetingRole:PIC')
    ->name('peserta.edit');

Route::put('peserta/{id_peserta}', [PesertaController::class, 'update'])
    ->middleware('CheckMeetingRole:PIC')
    ->name('peserta.update');

Route::delete('peserta/{id_peserta}', [PesertaController::class, 'destroy'])
    ->middleware('CheckMeetingRole:PIC')
    ->name('peserta.destroy');

Route::post('/peserta/kirim-notifikasi', [PesertaController::class, 'kirimNotifUndangan'])->name('peserta.kirimNotifikasi');


// Route::get('rapat/{id_rapat}/peserta', [PesertaController::class, 'index'])->name('peserta.index');

//rekap kehadiran
Route::get('/rekap-kehadiran/{id_rapat}', [PesertaController::class, 'rekap'])->name('rekap.kehadiran');
// Route::get('/rekap-kehadiran', [PesertaController::class, 'rekap'])->name('rekap.kehadiran');
Route::get('/rekap-kehadiran/download', [PesertaController::class, 'downloadRekap'])->name('rekap.download');
Route::post('/peserta/kehadiran/{id_peserta}', [PesertaController::class, 'konfirmasiKehadiran'])->name('peserta.konfirmasi');
Route::put('/peserta/{id_peserta}/update-status/{status}', [PesertaController::class, 'updateStatus'])->name('peserta.updateStatus');



// NOTULENSI
Route::get('/notulensicreate/{id_rapat}', [NotulensiController::class, 'create'])
    ->middleware('CheckMeetingRole:Moderator,PIC')
    ->name('notulensi.create');

Route::post('/notulensi', [NotulensiController::class, 'store'])
    ->name('notulensi.store');

Route::get('/notulensi/{id_notulensi}', [NotulensiController::class, 'show'])
    ->name('notulensi.show');

Route::get('/notulensi/{id_notulensi}/edit', [NotulensiController::class, 'edit'])
    ->middleware('CheckMeetingRole:Moderator,PIC')
    ->name('notulensi.edit');

Route::put('/notulensi/{id_notulensi}', [NotulensiController::class, 'update'])
    ->middleware('CheckMeetingRole:Moderator,PIC')
    ->name('notulensi.update');

Route::delete('/notulensi/{id_notulensi}', [NotulensiController::class, 'destroy'])
    ->middleware('CheckMeetingRole:Moderator,PIC')
    ->name('notulensi.destroy');

Route::get('/notulensi/{id}/download', [NotulensiController::class, 'downloadPDF'])
    ->name('notulensi.download');

//TINDAK LANJUT
Route::get('/tindaklanjutcreate/{id_rapat}', [TindakLanjutController::class, 'create'])
    ->middleware('CheckMeetingRole:Moderator,PIC')
    ->name('tindaklanjut.create');

Route::post('/tindaklanjut', [TindakLanjutController::class, 'store'])
    ->name('tindaklanjut.store');

Route::get('/tindaklanjut/admin/{id_tindaklanjut}', [TindakLanjutController::class, 'show'])->name('tindaklanjut.show');

Route::get('/tindaklanjut/{id_tindaklanjut}/edit', [TindaklanjutController::class, 'edit'])
    ->middleware('CheckMeetingRole:Moderator,PIC')
    ->name('tindaklanjut.edit');

Route::put('/tindaklanjut/{id_tindaklanjut}', [TindaklanjutController::class, 'update'])
    ->middleware('CheckMeetingRole:Moderator,PIC')
    ->name('tindaklanjut.update');

Route::delete('/tindaklanjut/{id_tindaklanjut}', [TindaklanjutController::class, 'destroy'])
    ->middleware('CheckMeetingRole:Moderator,PIC')
    ->name('tindaklanjut.destroy');

Route::get('/tindaklanjut/{id}/download-pdf', [TindakLanjutController::class, 'downloadPdf'])
    ->name('tindaklanjut.downloadPdf');

Route::get('/tindaklanjut/user/{id_tindaklanjut}', [TindakLanjutController::class, 'showuser'])->name('tindaklanjut.showuser');

// Upload Lampiran
Route::post('/tindaklanjut/{id_tindaklanjut}/upload', [TindakLanjutController::class, 'uploadLampiran'])->name('upload.lampiran');

// Lihat / Ubah Catatan Revisi
Route::get('/tindaklanjut/{id_tindaklanjut}/revisi', [TindakLanjutController::class, 'showRevisi'])->name('revisi.show');

// Update Status Tugas
Route::put('/tindaklanjut/{id_tindaklanjut}/status', [TindakLanjutController::class, 'updateStatus'])->name('tindaklanjut.updateStatus');

//Hapus hasil Tindak Lanjut
Route::delete('/hasil-tindaklanjut/{id_hasiltindaklanjut}', [TindakLanjutController::class, 'destroyhasiltindaklanjut'])->name('hasil-tindaklanjut.destroy');


//catatn revisi
Route::post('/catatan-revisi', [CatatanRevisiController::class, 'store'])->name('catatan-revisi.store');
Route::put('/catatan-revisi/{id}', [CatatanRevisiController::class, 'update'])->name('catatan-revisi.update');


//DOKUMENTASI
Route::get('/dokumentasicreate/{id_rapat}', [DokumentasiController::class, 'create'])
    ->middleware('CheckMeetingRole:Moderator,PIC')
    ->name('dokumentasi.create');

Route::post('/dokumentasi/store', [DokumentasiController::class, 'store'])
    ->name('dokumentasi.store');

Route::get('/dokumentasi/{id_dokumentasi}', [DokumentasiController::class, 'show'])
    ->name('dokumentasi.show');

Route::get('/dokumentasi/{id_dokumentasi}/edit', [DokumentasiController::class, 'edit'])
    ->middleware('CheckMeetingRole:Moderator,PIC')
    ->name('dokumentasi.edit');

Route::put('/dokumentasi/{id_dokumentasi}', [DokumentasiController::class, 'update'])
    ->middleware('CheckMeetingRole:Moderator,PIC')
    ->name('dokumentasi.update');

Route::delete('/dokumentasi/{id_dokumentasi}', [DokumentasiController::class, 'destroy'])
    ->middleware('CheckMeetingRole:Moderator,PIC')
    ->name('dokumentasi.destroy');

Route::get('/dokumentasi/{id}/download-pdf', [DokumentasiController::class, 'downloadPDF'])
    ->name('dokumentasi.downloadPDF');


//kelola pengguna
Route::get('/kelolauser', [UserController::class, 'kelolaUser'])->name('kelolauser');
Route::get('/tambahuser', [UserController::class, 'create'])->name('users.create');
Route::get('/kelolauser/{id}/edit', [UserController::class, 'edit'])->name('user.edit');
Route::put('/kelolauser/{id}/update', [UserController::class, 'update'])->name('user.update');
Route::delete('/kelolauser/{id}', [UserController::class, 'destroy'])->name('user.delete');
Route::post('/users', [UserController::class, 'store'])->name('users.store');
Route::post('/upload-foto', [UserController::class, 'uploadFoto'])->name('user.uploadFoto');

//route untuk user 

//halaman kelola rapat
Route::get('/user/rapat', [UndanganController::class, 'kelolaRapatUser'])->name('user.rapat');

//halaman meeting detail
Route::get('/user/rapat/{id}', [UndanganController::class, 'showMeetingDetailUser'])->name('user.rapat.detail');

