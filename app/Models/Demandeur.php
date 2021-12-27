<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Demandeur extends Model
{
    use HasFactory;
    protected $fillable = ['id','code','nom','prenom','email','numtel','departement','entite_de_recherche','responsable_entite','is_professeur','etablissement_id','grade_id','user_id'];
    public function etablissement(){
        return $this->belongsTo(Etablissement::class);
    }
    public function grade(){
        return $this->belongsTo(Grade::class);
    }
    public function demande(){
        return $this->hasMany(Demande::class);
    }
    public function user(){
        return $this->hasOne(Demande::class);
    }

}
