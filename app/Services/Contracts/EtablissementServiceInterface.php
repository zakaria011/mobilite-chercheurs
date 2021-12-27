<?php

namespace App\Services\Contracts;



interface EtablissementServiceInterface
{
    public function findByLibelle($libelle);
}
