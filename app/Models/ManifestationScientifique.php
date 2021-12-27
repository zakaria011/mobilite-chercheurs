<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ManifestationScientifique extends Model
{
    protected $fillable = ['id','intitule_participation','nature_participation','demande_id'];
    use HasFactory;
    public function demande(){
        return $this->hasOne(Demande::class);
    }
}
