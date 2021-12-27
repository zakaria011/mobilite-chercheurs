<?php

namespace App\Services\Contracts;

use Illuminate\Http\Request;

interface SoutienServiceInterface
{
   public function calculateSum($id);
   public function findMontants($id);
   public function modifySoutien(Request $request);

}
