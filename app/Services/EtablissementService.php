<?php

namespace App\Services;

use App\Models\Etablissement;
use App\Services\Contracts\EtablissementServiceInterface;

class EtablissementService implements EtablissementServiceInterface
{
    public function findByLibelle($libelle)
    {
        return Etablissement::where('libelle', $libelle)->first();
    }
}
