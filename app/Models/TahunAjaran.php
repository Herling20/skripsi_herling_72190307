<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TahunAjaran extends Model
{
    use HasFactory;
    protected $table = 'tahun_ajaran';
    protected $primaykey = 'id';
    public $timestamps = false;
    protected $fillable = [
        'semester',
        'tahun',
        'tanggalMulai',
        'tanggalSelesai',
    ];
}
