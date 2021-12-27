<?php

namespace App\Services;

use App\Models\Demandeur;
use App\Models\ResponseApi;
use App\Services\Contracts\DemandeurServiceInterface;
use Illuminate\Support\Facades\DB;

class DemandeurService implements DemandeurServiceInterface
{
    public function findByUser($id){


        $demandeur =  Demandeur::where('user_id',$id)->first();
        /*if(!$demandeur->is_professeur){
            $demandeur = DB::table('demandeurs')
                        ->join('doctorants', 'doctorants.demandeur_id', '=', 'demandeurs.id')
                        ->join('etablissements', 'etablissements.id', '=', 'demandeurs.etablissement_id')
                        ->where('demandeurs.user_id',$id)->get();
        }*/
        $reponse = new ResponseApi();
        $reponse->status = 200;
        $reponse->result = $demandeur;
        return response()->json(
                $reponse);
    }


    public function findAll()
    {
        $demandeurs = DB::table('demandeurs')
                    ->get();

        $reponse = new ResponseApi();
        $reponse->status = 200;
        $reponse->result = $demandeurs;
        return response()->json(
                $reponse);
                
    }
}
