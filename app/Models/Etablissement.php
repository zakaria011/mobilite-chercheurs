<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Etablissement extends Model
{
    protected $fillable = ['id','libelle'];
    use HasFactory;
    public function demandeurs(){
        return $this->hasMany(Demandeur::class);
    }
}
