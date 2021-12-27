<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Etat extends Model
{
    protected $fillable = ['id','libelle'];
    use HasFactory;
    public function demande(){
        return $this->belongsTo(Demande::class);
    }
}
