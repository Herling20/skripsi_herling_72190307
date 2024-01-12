<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailBimbingan extends Model
{
    use HasFactory;
    // protected $guard = 'milestone';
    protected $table = 'detailbimbingan';
    protected $primaykey = 'detailBimbingan_id';
    public $timestamps = false;
    protected $fillable = [
        'bimbingan_id',
        'milestone_id',
        'tanggalPengajuan',
        'deskripsiPengajuan',
        'tanggalBimbingan',
        'jamMulai',
        'jamSelesai',
        'catatanBimbingan',
        'statusBimbingan',
        'acc_dp1',
        'acc_dp2',
        'statusMilestone',
    ];

    // protected $casts = [
    //     'tanggalBimbingan' => 'datetime'
    // ];

    public function bimbingan()
    {
        return $this->belongsTo(Bimbingan::class, 'bimbingan_id', 'bimbingan_id');
    }

    public function milestone()
    {
        return $this->belongsTo(Milestone::class, 'milestone_id', 'id');
    }
}
