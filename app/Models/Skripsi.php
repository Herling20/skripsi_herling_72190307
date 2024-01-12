<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Skripsi extends Model
{
    use HasFactory;
    // protected $guard = 'milestone';
    protected $table = 'judulskripsi';
    protected $primaykey = 'skripsi_id';
    protected $fillable = [
        'mahasiswa_id',
        'judul',
        'tanggalMasuk',
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'mahasiswa_id', 'id');
    }
}
