<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;


    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'telephone', 
        'foto', 
        'role'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function pesertas()
{
    return $this->hasMany(Peserta::class, 'id_user', 'id');
}
public function tindakLanjuts()
{
    return $this->belongsToMany(TindakLanjut::class, 'tindak_lanjut_user', 'id_user', 'id_tindaklanjut')
                ->withTimestamps()
                ->withPivot('status_tugas');
}

public function tindaklanjutUser()
{
    return $this->hasOne(TindakLanjutUser::class, 'id_user');
}

}
