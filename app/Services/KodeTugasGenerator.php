<?php

namespace App\Services;

use App\Models\TugasTeknisi;

class KodeTugasGenerator
{
    public function generate()
    {
        $lastIDTugas = TugasTeknisi::orderBy('tugas_id', 'desc')->first();
        if (!$lastIDTugas) {
            return 'TUGAS-00001';
        }

        $lastCode = $lastIDTugas->tugas_id;
        $numericPart = preg_replace('/[^0-9]/', '', $lastCode);
        $nextNumber = intval($numericPart) + 1;

        return 'TUGAS' . '-' .  str_pad($nextNumber, 5, '0', STR_PAD_LEFT);
    }
}
