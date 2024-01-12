<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
// use App\Models\Milestone;
// use Illuminate\Database\Eloquent\Model;

class Dosen extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $guard = 'dosen';
    /**
    * The attributes that are mass assignable.
    *
    * @var array<int, string>
    */
    
    protected $table = 'dosens';
    protected $primaykey = 'id';

    
    protected $fillable = [
        'nidn',
        'nama',
        'email',
        'foto',
        'noHp',
        'jenisKelamin',
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

    // public function mahasiswa()
    // {
    //     return $this->hasMany(Mahasiswa::class, 'dosenPembimbing1', 'id');
    //     return $this->hasMany(Mahasiswa::class, 'dosenPembimbing2', 'id');

    // }

    public function milestone()
    {
        return $this->hasMany(Milestone::class, 'dosen_id', 'id');
    }

    public function bimbingan()
    {
        return $this->hasMany(Bimbingan::class, 'dosen_id', 'id');
    }
}
