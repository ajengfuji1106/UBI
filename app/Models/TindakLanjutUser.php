<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TindakLanjutUser extends Model
{
    protected $table = 'tindak_lanjut_user';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id_user', 'id_tindaklanjut', 'status_tugas'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function tindakLanjut()
    {
        return $this->belongsTo(TindakLanjut::class, 'id_tindaklanjut');
    }
    public function catatanRevisi()
{
    return $this->hasMany(CatatanRevisi::class, 'id_tindak_lanjut_user', 'id');
}


    // public function catatanRevisi()
    // {
        // return $this->hasOne(catatanRevisi::class, 'id_user', 'id_user')
            // ->whereColumn('id_tindaklanjut', 'tindak_lanjut_user.id_tindaklanjut');
    // }
}

