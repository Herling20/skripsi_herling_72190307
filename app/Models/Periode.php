<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Periode extends Model
{
    use HasFactory;
    // protected $guard = 'milestone';
    protected $table = 'periode';
    protected $primaykey = 'id';
    public $timestamps = false;
    protected $fillable = [
        'mahasiswa_id',
        'semester',
        'tahunMulai',
        'tahunSelesai',
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'mahasiswa_id', 'id');
    }
}
