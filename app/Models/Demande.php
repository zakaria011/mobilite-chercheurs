<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Demande extends Model
{
    protected $fillable = ['intitule','date_debut','date_fin','date_depart','date_retour','is_mission','pays','ville','demandeur_id','etat_id'];


    use HasFactory;
    public function manifestation(){
        return $this->hasOne(ManifestationScientifique::class);

    }
    public function missionstage(){
        return $this->hasOne(MissionStage::class);
    }
    public function soutien(){
        return $this->hasOne(Soutien::class);
    }
    public function etat(){
        return $this->belongsTo(Etat::class);
    }
    public function demandeur(){
        return $this->belongsTo(Demandeur::class);
    }



}



