<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class rapat extends Model
{
    use HasFactory;

    protected $table = 'rapats';
    protected $primaryKey = 'id_rapat';
    protected $fillable = ['id_user', 'judul_rapat', 'tanggal_rapat',
    'waktu_rapat', 'lokasi_rapat', 'kategori_rapat', 'status_rapat'];

        public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function undangan()
{
    return $this->hasOne(Undangan::class, 'id_rapat');
}

public function peserta()
{
    return $this->hasMany(Peserta::class, 'id_rapat');
}

//menampung data notulensi, tindak lanjut, dan dokumentasi
public function notulensis()
{
    return $this->hasMany(Notulensi::class, 'id_rapat', 'id_rapat');
}

public function tindakLanjuts()
{
    return $this->hasMany(TindakLanjut::class, 'id_rapat', 'id_rapat');
}

public function dokumentasis()
{
    return $this->hasMany(Dokumentasi::class, 'id_rapat', 'id_rapat');
}

public static function getData($id_rapat)
    {
        $data = parent::findOrFail($id_rapat);

        $data->tanggal_rapat = Carbon::parse($data->tanggal_rapat)->locale('id')->translatedFormat('j F Y');
        $data->waktu_rapat = Carbon::parse($data->waktu_rapat)->format('H.i');

        return $data;
    }

}
