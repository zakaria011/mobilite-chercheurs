<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Action extends Model
{
    protected $fillable = ['id','libelle'];
    use HasFactory;
    public function montant(){
        return $this->hasMany(Montant::class);
    }
}
