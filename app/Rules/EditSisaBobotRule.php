<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\InvokableRule;
use App\Models\Milestone;
use Illuminate\Support\Facades\Auth;

class EditSisaBobotRule implements InvokableRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function __invoke($attribute, $value, $fail)
    {
        $semester = request()->input('semester');
        $milestone_id = request()->input('milestone_id');
        $dosen = Auth::user()->id;

        // $totalBobotDatabase = Milestone::where('semester', $semester)->sum('bobot')
        //             ->where('id', '!=', $milestone_id)
        //             ->sum('bobot');

        $totalBobotDatabase = Milestone::where('semester', $semester)
                        ->where('dosen_id', $dosen)
                        ->when($milestone_id, function ($query) use ($milestone_id) {
                            $query->where('id', '!=', $milestone_id);
                        })
                        ->sum('bobot');

        $totalBobotInput = $totalBobotDatabase + $value;

        if ($totalBobotInput >= 100) {
            $fail('Sisa bobot untuk semester ini melebihi 100%. Sisa Bobot: ' . (100 - $totalBobotDatabase));
        }
    }
}
