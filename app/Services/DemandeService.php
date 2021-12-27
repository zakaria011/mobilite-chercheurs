<?php

namespace App\Services;

use App\Models\Demande;
use App\Models\Demandeur;
use App\Models\ManifestationScientifique;
use App\Models\MissionStage;
use App\Models\Montant;
use App\Models\ResponseApi;
use App\Models\Soutien;
use App\Services\Contracts\DemandeServiceInterface;
use App\Services\Contracts\SoutienServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class DemandeService implements DemandeServiceInterface
{

    protected  $soutienService;

    public function __construct(SoutienServiceInterface $soutienService)
    {
        $this->soutienService = $soutienService;
    }
    public function create($request){
        $demande = new Demande();
        $demande->intitule = $request->intitule;
        $demande->is_mission = $request->is_mission;
        $demande->date_debut = $request->date_debut;
        $demande->date_fin = $request->date_fin;
        $demande->date_depart = $request->date_depart;
        $demande->date_retour = $request->date_retour;
        $demande->pays = $request->pays;
        $demande->ville = $request->ville;
        $demande->etat_id = 1;
        $demande->demandeur_id = $request->demandeur_id;
        $demande->save();
        if($request->is_mission){
            $mission = new MissionStage();
            $mission->intitule_projet =  $request->intitule_projet;
            $mission->respo_marocain =  $request->respo_marocain;
            $mission->respo_etranger =  $request->respo_etranger;
            $mission->cadre =  $request->cadre;
            $mission->is_rem =  $request->is_rem === "true" ? true : false;
            $mission->demande_id =  $demande->id;
            $mission->save();
        }else{
            $manifestation = new ManifestationScientifique();
            $manifestation->intitule_participation =  $request->intitule_participation;
            $manifestation->nature_participation =  $request->nature_participation;
            $manifestation->demande_id =  $demande->id;
            $manifestation->save();
        }

        if($demande->id){
            $soutien = new Soutien();
            if($request->type){
                $soutien->type = "TOTAL";
            }else{
                $soutien->type = "COMPLEMANTAIRE";
            }
            $soutien->is_beneficie = $request->is_beneficie === "true" ? true : false;
            $soutien->montant_soutien_precedent = $request->montant_soutien_precedent;
            $soutien->cadre = "NOT DEFINED";
            $soutien->sources = "NOT DEFINED";
            if($soutien->is_beneficie){
                $soutien->montant_soutien_precedent = $request->montant_soutien_precedent;
            }
            $soutien->demande_id = $demande->id;
            $soutien->save();
        }
        if($soutien->id){
            // ----------------------------------------------
            $montant = new Montant();
            $montant->montant = $request->montantHeberegement;
            $montant->soutien_id = $soutien->id;
            $montant->action_id = 1;
            $montant->save();
             // ----------------------------------------------
            $montant = new Montant();
            $montant->montant = $request->montantTransport;
            $montant->soutien_id = $soutien->id;
            $montant->action_id = 2;
            $montant->save();
            // ----------------------------------------------
            $montant = new Montant();
            $montant->montant = $request->montantInscription;
            $montant->soutien_id = $soutien->id;
            $montant->action_id = 3;
            $montant->save();
            // ----------------------------------------------
            $montant = new Montant();
            $montant->montant = $request->autreMontant;
            $montant->soutien_id = $soutien->id;
            $montant->action_id = 4;
            $montant->save();
        }
        $reponse = new ResponseApi();
            $reponse->status = 200;
            $reponse->result = $demande;
        return response()->json(
            $reponse);

    }
    /**
     * Update the specified user.
     *
     *
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */

    public function findByDemandeur($id){
        $num = (int)$id;
        $demandeur = Demandeur::where('user_id',$num)->first();
        $demandes = DB::table('demandes')
                    ->join('etats', 'demandes.etat_id', '=', 'etats.id')
                    ->where('demandes.demandeur_id',$demandeur->id)->get();



        $reponse = new ResponseApi();
        $reponse->status = 200;
        $reponse->result = $demandes;
        return response()->json(
                $reponse);
    }


    public function findAll(){

        $demandes = DB::table('demandes')
                    ->join('etats', 'demandes.etat_id', '=', 'etats.id')
                    ->join('demandeurs', 'demandeurs.id', '=', 'demandes.demandeur_id')
                    ->select(
                        'demandeurs.nom',
                        'demandeurs.prenom',
                        'etats.libelle',
                        'demandes.id',
                        'demandes.created_at'
                    )
                    ->get();

        $reponse = new ResponseApi();
        $reponse->status = 200;
        $reponse->result = $demandes;
        return response()->json(
                $reponse);

    }

    public function findByState($state){
        $demandes = DB::table('demandes')
                    ->join('etats', 'demandes.etat_id', '=', 'etats.id')
                    ->join('demandeurs', 'demandeurs.id', '=', 'demandes.demandeur_id')
                    ->where('etats.libelle',$state)
                    ->select(
                        'demandeurs.nom',
                        'demandeurs.prenom',
                        'etats.libelle',
                        'demandes.id',
                        'demandes.created_at'
                    )
                    ->get();

        $reponse = new ResponseApi();
        $reponse->status = 200;
        $reponse->result = $demandes;
        return response()->json(
                $reponse);
    }

    public function findDetails($id){


        $demande = DB::table('demandes')
                    ->join('demandeurs', 'demandeurs.id', '=', 'demandes.demandeur_id')
                    ->where('demandes.id',$id)
                    ->first();
        if($demande->is_mission && $demande->is_professeur){
            $demande = DB::table('demandes')
                    ->join('etats', 'demandes.etat_id', '=', 'etats.id')
                    ->join('demandeurs', 'demandeurs.id', '=', 'demandes.demandeur_id')
                    ->join('etablissements', 'etablissements.id', '=', 'demandeurs.etablissement_id')
                    ->join('mission_stages', 'demandes.id', '=', 'mission_stages.demande_id')
                    ->join('soutiens', 'soutiens.demande_id', '=', 'demandes.id')
                    ->join('grades', 'grades.id', '=', 'demandeurs.grade_id')
                    ->select('demandes.id as demandeId','demandes.*','mission_stages.*','grades.libelle','demandeurs.*'
                    , 'soutiens.id as soutienId','soutiens.*',
                    'etablissements.libelle as etablissement'
                    )
                    ->where('demandes.id',$id)
                    ->first();
        }else{
            if($demande->is_mission && !$demande->is_professeur){
                $demande = DB::table('demandes')
                    ->join('etats', 'demandes.etat_id', '=', 'etats.id')
                    ->join('demandeurs', 'demandeurs.id', '=', 'demandes.demandeur_id')
                    ->join('etablissements', 'etablissements.id', '=', 'demandeurs.etablissement_id')
                    ->join('mission_stages', 'demandes.id', '=', 'mission_stages.demande_id')
                    ->join('doctorants', 'demandeurs.id', '=', 'doctorants.demandeur_id')
                    ->join('soutiens', 'soutiens.demande_id', '=', 'demandes.id')
                    ->select('demandes.id as demandeId','demandes.*','mission_stages.*','doctorants.*','demandeurs.*',
                        'soutiens.id as soutienId','soutiens.*',
                        'etablissements.libelle as etablissement'
                        )
                    ->where('demandes.id',$id)
                    ->first();
            }else{
                if(!$demande->is_mission && $demande->is_professeur){
                    $demande = DB::table('demandes')
                    ->join('etats', 'demandes.etat_id', '=', 'etats.id')
                    ->join('demandeurs', 'demandeurs.id', '=', 'demandes.demandeur_id')
                    ->join('etablissements', 'etablissements.id', '=', 'demandeurs.etablissement_id')
                    ->join('manifestation_scientifiques', 'demandes.id', '=', 'manifestation_scientifiques.demande_id')
                    ->join('grades', 'grades.id', '=', 'demandeurs.grade_id')
                    ->join('soutiens', 'soutiens.demande_id', '=', 'demandes.id')
                    ->select('demandes.id as demandeId','demandes.*','manifestation_scientifiques.*','grades.libelle','demandeurs.*',
                     'soutiens.id as soutienId', 'soutiens.*',
                     'etablissements.libelle as etablissement'
                    )
                    ->where('demandes.id',$id)
                    ->first();
                }else{
                    $demande = DB::table('demandes')
                    ->join('etats', 'demandes.etat_id', '=', 'etats.id')
                    ->join('demandeurs', 'demandeurs.id', '=', 'demandes.demandeur_id')
                    ->join('etablissements', 'etablissements.id', '=', 'demandeurs.etablissement_id')
                    ->join('manifestation_scientifiques', 'demandes.id', '=', 'manifestation_scientifiques.demande_id')
                    ->join('doctorants', 'demandeurs.id', '=', 'doctorants.demandeur_id')
                    ->join('soutiens', 'soutiens.demande_id', '=', 'demandes.id')
                    ->select('demandes.id as demandeId','demandes.*','manifestation_scientifiques.*','doctorants.*',
                    'demandeurs.*', 'soutiens.id as soutienId','soutiens.*',
                    'etablissements.libelle as etablissement'
                    )
                    ->where('demandes.id',$id)
                    ->first();
                }
            }


        }

        $montants = Montant::where('soutien_id',$demande->soutienId)
                    ->orderBy('action_id', 'asc')
                    ->get();


        $reponse = new ResponseApi();
        $reponse->status = 200;
        $reponse->result = [
            'demande' => $demande,
            'motants' => $montants
        ];
        //$reponse->result->montant = $montant;
        return response()->json(
                $reponse);
    }


    public function validate(Request $request){
        $demande = Demande::find($request->id);
        $demande->etat_id = 2;
        $demande->save();

        $reponse = new ResponseApi();
        $reponse->status = 200;
        $reponse->result = $demande;
        return response()->json(
                $reponse);
    }

    public function refuse(Request $request){

        $demande = Demande::find($request->id);
        $demande->etat_id = 3;
        $demande->save();

        $reponse = new ResponseApi();
        $reponse->status = 200;
        $reponse->result = $demande;
        return response()->json(
                $reponse);

    }

    public function getLettre($id){
        $demande = Demande::find($id);
        if($demande->etat()->libelle == 'acceptee'){
            $soutien = Soutien::where('demande_id',$id);
            $montantCalcule = $this->soutienService->calculateSum($soutien->id);
            

        }
    }




}
