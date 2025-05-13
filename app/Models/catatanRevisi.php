<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class catatanRevisi extends Model
{
    use hasFactory;
    protected $table = 'catatan_revisis';
    protected $primaryKey = 'id_catatanrevisi';
    protected $fillable = [
        'id_tindak_lanjut_user',
        // 'id_tindaklanjut',
        // 'id_user',
        'catatanrevisi',
    ];
     public function tindakLanjutUser()
    {
        return $this->belongsTo(TindakLanjutUser::class, 'id_tindak_lanjut_user');
    }
    // public function tindak_lanjuts() {
        // return $this->belongsTo(tindakLanjut::class, 'id_tindaklanjut');
    // }
    // public function user()
    // {
        // return $this->belongsTo(User::class, 'id_user');
    // }
}
