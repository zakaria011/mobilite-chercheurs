<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\models\Demandeur;
use App\models\Doctorant;
use App\models\ResponseApi;
use App\Services\Contracts\DemandeurServiceInterface;
use App\Services\Contracts\EtablissementServiceInterface;
use App\Services\Contracts\GradeServiceInterface;
use App\Services\EtablissementService;

class DemandeurController extends Controller
{
    protected $etablissementService;
    protected $gradeService;
    protected $demandeurService;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct(EtablissementServiceInterface $etablissementService,
                    GradeServiceInterface $gradeService,
                    DemandeurServiceInterface $demandeurService
    )
    {
        $this->gradeService = $gradeService;
        $this->etablissementService = $etablissementService;
        $this->demandeurService = $demandeurService;
    }


    public function index()
    {
        return
            $this->demandeurService->findAll();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $demandeur = new Demandeur;
        $demandeur->etablissement_id = $this->etablissementService->findByLibelle($request->etablissement)->id;
        $demandeur->code  = "3432t42";
        $demandeur->departement  = "info";
        $demandeur->nom = $request->nom;
        $demandeur->prenom = $request->prenom;
        $demandeur->email = $request->email;
        $demandeur->numTel = $request->numTel;
        $demandeur->responsable_entite = $request->responsable_entite;
        $demandeur->entite_de_recherche = $request->entite_de_recherche;
        $demandeur->user_id = $request->user_id;


        $demandeur->is_professeur = json_decode($request->is_professeur);

        if( $demandeur->is_professeur){
             $demandeur->grade_id  = $this->gradeService->findByLibelle($request->grade)->id;
             $demandeur->save();

        }else{
            $demandeur->save();
            $id = $demandeur->id;
            $doctorant = new Doctorant;
            $doctorant->is_officiel =  $request->is_officiel === "true" ? true : false;
            $doctorant->directeur_these = $request->directeur_these;
            $doctorant->ced = $request->ced;
            $doctorant->annee_these = $request->annee_these;
            $doctorant->demandeur_id = $id;
            $doctorant->save();

        }
            $response = new ResponseApi();
            $response->status = 200;
            $response->result = $demandeur;
        return response()->json(
            $response);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    public function findByUser($id)
    {
        return
            $this->demandeurService->findByUser($id);
    }
}
