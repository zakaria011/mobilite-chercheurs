<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MissionStage extends Model
{
    protected $fillable = ['id','intitule_projet','respo_marocain','respo_etranger','cadre','reference','is_rem','demande_id'];
    use HasFactory;
    public function demande(){
        return $this->hasOne(Demande::class);
    }
}
