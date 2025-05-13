<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class peserta extends Model
{
    use HasFactory;
    protected $table = 'pesertas';
    protected $primaryKey = 'id_peserta';
    protected $fillable = ['id_user', 'id_rapat', 'status_kehadiran', 'role_peserta', 'bukti_kehadiran'];
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
    public function rapat()
    {
        return $this->belongsTo(Rapat::class, 'id_rapat');
    }
}
