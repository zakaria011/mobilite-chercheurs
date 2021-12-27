<?php

namespace App\Services\Contracts;

use Illuminate\Http\Request;

interface DemandeServiceInterface
{
    public function create($request);
    public function findByDemandeur($id);
    public function findByState($state);
    public function findAll();
    public function findDetails($id);
    public function validate(Request $request);
    public function refuse(Request $request);
    public function getLettre($id);
}
