<?php

namespace App\Services;

use App\Models\Montant;
use App\Models\ResponseApi;
use App\Services\Contracts\SoutienServiceInterface;
use Illuminate\Http\Request;

class SoutienService implements SoutienServiceInterface
{


    public function findMontants($id){
        $montant = Montant::where('soutien_id',$id)->get();
        return $montant;
    }

    public function calculateSum($id){
        $montants = Montant::where('soutien_id',$id)
        ->get();
        $sum = 0;
        foreach($montants as $montant){
            $sum += $montant->montant;
        }
        return $sum;

    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function modifySoutien(Request $request)
    {

        $montants = Montant::where('soutien_id',$request->soutienId)
                    ->orderBy('action_id', 'asc')
                    ->get();
        $montants = $montants->toArray();
        if($request->montantHeberegement){
            $montant = Montant::find($montants[0]['id']);
            $montant->montant = $request->montantHeberegement;
            $montant->save();
        }
        if($request->montantTransport){
            $montant = Montant::find($montants[1]['id']);
            $montant->montant = $request->montantTransport;
            $montant->save();
        }
        if($request->montantInscription){
            $montant = Montant::find($montants[2]['id']);
            $montant->montant = $request->montantInscription;
            $montant->save();
        }

        if($request->autreMontant){
            $montant = Montant::find($montants[3]['id']);
            $montant->montant = $request->autreMontant;
            $montant->save();
        }

        $reponse = new ResponseApi();
        $reponse->status = 200;
        return response()->json(
                $reponse);

    }
}
