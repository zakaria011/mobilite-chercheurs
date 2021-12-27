<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PiecesJointes extends Model
{
    use HasFactory;

    protected $fillable = ['id','path','name','extention','demandeur_id'];

    public function demandeur(){
        return $this->belongsTo(Demandeur::class);
    }

}
