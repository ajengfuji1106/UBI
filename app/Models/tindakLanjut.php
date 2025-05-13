<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class tindakLanjut extends Model
{
    use HasFactory;
    
    protected $table = 'tindak_lanjuts';
    protected $primaryKey = 'id_tindaklanjut';
    protected $fillable = [
        'id_rapat', 'id_user', 'judul_tugas', 'deadline_tugas', 
        'deskripsi_tugas', 'status_tugas', 'file_path'
    ];
    public function rapat()
    {
        return $this->belongsTo(Rapat::class, 'id_rapat');
    }
    public function users()
{
    return $this->belongsToMany(User::class, 'tindak_lanjut_user', 'id_tindaklanjut', 'id_user')
                ->withTimestamps()
                ->withPivot('status_tugas');
}

    // public function user()
    // {
        // return $this->belongsTo(User::class, 'id_user');
    // }

    public static  function getData($id_tindaklanjut){
        $data=parent::findOrFail($id_tindaklanjut);        
        $parsed_data=Carbon::parse($data->deadline_tugas)->translatedFormat('d F Y');
        $data->deadline_tugas= $parsed_data;
        return $data;
        
    }

    public function hasil()
    {
        return $this->hasMany(HasilTindakLanjut::class, 'id_tindaklanjut');
    }

}
