<?php

namespace App\Services\Contracts;



interface DemandeurServiceInterface
{
    public function findByUser($id);
    public function findAll();
}
