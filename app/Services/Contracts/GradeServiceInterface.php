<?php

namespace App\Services\Contracts;



interface GradeServiceInterface
{
    public function findByLibelle($libelle);
}
