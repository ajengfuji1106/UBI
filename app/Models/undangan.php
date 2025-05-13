<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class undangan extends Model
{
    use HasFactory;

    protected $table = 'undangans';
    protected $primaryKey = 'id_undangan';
    protected $fillable = [
        'id_rapat',
        'file_undangan',
    ];

    public function rapat()
    {
        return $this->belongsTo(Rapat::class, 'id_rapat');
    }
    
}
