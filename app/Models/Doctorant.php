<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctorant extends Demandeur
{
    protected $fillable = ['is_officiel','directeur_these','ced','annee_these','demandeur_id'];
    use HasFactory;
    public function Demandeur(){
        return $this->belongsTo(Demandeur::class);
    }



}
