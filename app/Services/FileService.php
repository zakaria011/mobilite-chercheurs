<?php

namespace App\Services;

use App\Models\PiecesJointes;
use App\Models\ResponseApi;
use App\Services\Contracts\FileServiceInterface;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\ArrayItem;

class FileService implements FileServiceInterface
{


    public function uploadFile(Request $request){
        $piece = new PiecesJointes();

        if($request->hasFile('file')){
            $extention = $request->file('file')->getClientOriginalExtension();
            $completeNameFile = $request->file('file')->getClientOriginalName();
            $fileNameOnly = pathinfo($completeNameFile,PATHINFO_FILENAME);
            $comp = str_replace(' ','_',$fileNameOnly). '-'. rand() .'_' .time().'.'.$extention;
            $path = $request->file('file')->storeAs('public/piecesjointes',$comp);
            $piece->name = $request->name;
            $piece->completeNameFile =  $comp;
            $piece->extension = $extention;
            $piece->path = $path;

            if($piece->save()){
                $reponse = new ResponseApi();
                $reponse->status = 200;
                $reponse->message = "file uploaded successfully";
                return response()->json(
                    $reponse);

            }else {

                $reponse = new ResponseApi();
                $reponse->status = 500;
                $reponse->message = "Something went wrong...";
                return response()->json(
                    $reponse);
            }

        }
    }

    public function getFilesByDemandeur($id){
        $files = PiecesJointes::where('demandeur_id',$id)->get();

        $reponse = new ResponseApi();
                $reponse->status = 200;
                $reponse->result = $files;
                return response()->json(
                    $reponse);


    }

    public function downloadFile($name){
        //$path = substr($request,7);
        $path ='storage\\'.'piecesjointes\\' . $name;
        $path = public_path($path);
        return response()->download($path);
    }

}
