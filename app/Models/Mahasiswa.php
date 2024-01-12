<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
// use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $guard = 'mahasiswa';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    // protected $guard = 'mahasiswa';
    protected $table = 'mahasiswas';
    protected $primaykey = 'id';

    protected $fillable = [
        'nim',
        'nama',
        'jenisKelamin',
        'email',
        'foto',
        'noHp',
        'ipk',
        'jumlah_sks',
        // 'periode',
        'angkatan',
        // 'judulSkripsi',
        // 'dosenPembimbing1',
        // 'dosenPembimbing2',
        'password',
        
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */

    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function periode()
    {
        return $this->hasOne(Periode::class, 'mahasiswa_id', 'id');
    }

    public function judulskripsi()
    {
        return $this->hasMany(Skripsi::class, 'mahasiswa_id', 'id');
    }


    public function bimbingan()
    {
        return $this->hasMany(Bimbingan::class, 'mahasiswa_id', 'id');
    }

}
