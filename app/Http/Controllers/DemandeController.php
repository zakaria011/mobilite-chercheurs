<?php

namespace App\Http\Controllers;

use App\Models\Demande;
use Illuminate\Http\Request;
use App\Services\Contracts\DemandeServiceInterface;

class DemandeController extends Controller
{
    protected  $demandeService;

    public function __construct(DemandeServiceInterface $demandeService)
    {
        $this->demandeService = $demandeService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return
            $this->demandeService->findAll();
    }
    public function findByState($state)
    {
        return
            $this->demandeService->findByState($state);
    }

    public function findByDemandeur($id)
    {
        return
            $this->demandeService->findByDemandeur($id);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return
            $this->demandeService->create($request);
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

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
    public function findDetails($id){
        return
            $this->demandeService->findDetails($id);
    }


    public function validateDemande(Request $request){
        return
            $this->demandeService->validate($request);
    }

    public function refuseDemande(Request $request){
        return
            $this->demandeService->refuse($request);

    }

    public function getLettre($id){
        return
            $this->demandeService->getLettre($id);
    }


}
