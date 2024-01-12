<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bimbingan extends Model
{
    use HasFactory;
    // protected $guard = 'milestone';
    protected $table = 'bimbingan';
    protected $primaykey = 'bimbingan_id';
    public $timestamps = false;
    protected $fillable = [
        'mahasiswa_id',
        'dosen_id',
        'level_pembimbing',
        'status',
        'insert_log',
        'update_log',
    ];

    public function detail_bimbingan()
    {
        return $this->hasMany(DetailBimbingan::class, 'bimbingan_id', 'bimbingan_id');
    }

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'mahasiswa_id', 'id');
    }
    public function dosen()
    {
        return $this->belongsTo(Dosen::class, 'mahasiswa_id', 'id');
    }
}
