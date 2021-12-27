<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Contracts\FileServiceInterface;

class FileController extends Controller


{
    protected $fileService;
    public function __construct(FileServiceInterface $fileService)
    {
        $this->fileService = $fileService;
    }


    public function uploadFile(Request $request){
        return $this->fileService->uploadFile($request);
    }
}
