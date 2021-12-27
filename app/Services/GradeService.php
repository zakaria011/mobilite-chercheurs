<?php

namespace App\Services;

use App\Models\Grade;
use App\Services\Contracts\GradeServiceInterface;

class GradeService implements GradeServiceInterface
{


    public function findByLibelle($libelle){
        return Grade::where('libelle', $libelle)->first();
    }
}
