<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class fileDokumentasi extends Model
{
    protected $table = 'file_dokumentasis';
    protected $fillable = [
    'id_dokumentasi',
    'file_path',
    ];

    public function dokumentasi()
    {
        return $this->belongsTo(Dokumentasi::class, 'id_dokumentasi');
    }
}
