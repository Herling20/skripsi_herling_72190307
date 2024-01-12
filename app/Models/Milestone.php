<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Milestone extends Model
{
    use HasFactory;
    // protected $guard = 'milestone';
    protected $table = 'milestones';
    protected $primaykey = 'id';
    public $timestamps = false;
    protected $fillable = [
        'id_dosen',
        'namaMilestone',
        'bobot',
        'waktu_awal',
        'waktu_akhir',
    ];

    public function dosen()
    {
        return $this->belongsTo(Dosen::class, 'dosen_id', 'id');
    }
}
