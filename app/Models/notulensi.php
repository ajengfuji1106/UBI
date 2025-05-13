<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class notulensi extends Model
{
    use HasFactory;
    protected $table = 'notulensis';
    protected $primaryKey = 'id_notulensi';
    protected $fillable = ['id_rapat', 'id_user', 'judul_notulensi', 'konten_notulensi'];

    public function rapat()
    {
        return $this->belongsTo(Rapat::class, 'id_rapat');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
