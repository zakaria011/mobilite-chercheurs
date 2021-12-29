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

    public function getFilesByDemandeur($id){

        return $this->fileService->getFilesByDemandeur($id);
    }

    public function downloadFile($name){

        return $this->fileService->downloadFile($name);
    }
}
