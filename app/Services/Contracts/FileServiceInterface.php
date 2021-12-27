<?php

namespace App\Services\Contracts;

use Illuminate\Http\Request;

interface FileServiceInterface
{
    public function uploadFile(Request $request);
}
