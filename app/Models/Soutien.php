<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Soutien extends Model
{
    protected $fillable = ['id','type','is_beneficie','montant_soutien_precedent','cadre','sources','demande_id'];
    use HasFactory;
    public function montant(){
        return $this->hasMany(Montant::class);
    }
    public function demande(){
        return $this->hasOne(Demande::class);
    }
}
