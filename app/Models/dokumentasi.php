<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class dokumentasi extends Model
{
    use HasFactory;

    protected $table = 'dokumentasis';
    protected $primaryKey = 'id_dokumentasi';
    protected $fillable = [
        'id_rapat', 
        'judul_dokumentasi', 
        'deskripsi', 
    ];

    public function rapat() {
        return $this->belongsTo(Rapat::class, 'id_rapat');
    }

    public function files()
{
    return $this->hasMany(FileDokumentasi::class, 'id_dokumentasi', 'id_dokumentasi');
}
}
