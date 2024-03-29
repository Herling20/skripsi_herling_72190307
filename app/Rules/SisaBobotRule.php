<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\InvokableRule;
use App\Models\Milestone;
use App\Models\TahunAjaran;
use Illuminate\Support\Facades\Auth;

class SisaBobotRule implements InvokableRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function __invoke($attribute, $value, $fail)
    {
        $tahunAjaranAktif = TahunAjaran::where('status', '=', 'Aktif')
                            ->select('tanggalMulai','tanggalSelesai')
                            ->first();

        $dosen = Auth::user()->id;

        $semester = request()->input('semester');
        $totalBobotDatabase = Milestone::whereBetween('tanggalBerakhir', [$tahunAjaranAktif->tanggalMulai, $tahunAjaranAktif->tanggalSelesai])
                            ->where('dosen_id', $dosen)
                            ->where('semester', $semester)
                            ->sum('bobot');

        $totalBobotInput = $totalBobotDatabase + $value;

        if ($totalBobotInput > 100 && $semester != null) {
            $fail('Sisa bobot untuk semester ini melebihi 100%.  Sisa Bobot: ' . (100 - $totalBobotDatabase));
        }
    }
}
