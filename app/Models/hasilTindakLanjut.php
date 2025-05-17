<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class hasilTindakLanjut extends Model
{
    use HasFactory;
    protected $table = 'hasil_tindak_lanjuts';
    protected $primaryKey = 'id_hasiltindaklanjut';
    protected $fillable = [
        'id_tindaklanjut',
        'id_user',
        'file_path',
        'nama_file_asli',
        'status_tugas',
    ];
    public function tindak_lanjuts() {
        return $this->belongsTo(tindakLanjut::class, 'id_tindaklanjut');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
    public function catatanRevisi()
{
    return $this->hasMany(CatatanRevisi::class, 'id_hasiltindaklanjut', 'id_hasiltindaklanjut');
}

    // public function catatanRevisi()
    // {
        // return $this->hasMany(CatatanRevisi::class, 'id_tindak_lanjut_user', 'id_hasiltindaklanjut');
    // }

}
