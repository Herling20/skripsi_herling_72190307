<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasOne;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $fillable = [
        'kodeUser',
        'nama',
        'role',
        'jenis_kelamin',
        'email',
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

    public function detailMahasiswa()
    {
        return $this->hasOne(DetailMahasiswa::class, 'id_mahasiswa', 'id');
    }

    public function milestone()
    {
        return $this->belongsTo(Milestone::class, 'id_dosen', 'id');
    }
    
    // protected function role(): Attribute
    // {
    //     return new Attribute(
    //         get: fn (String $value) =>  ["admin", "dosen", "mahasiswa"][$value],
    //     );
    // }
}
