<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Montant extends Model
{
    protected $fillable = ['id','soutien_id','action_id','montant'];
    use HasFactory;
    public function soutien(){
        return $this->belongsTo(Soutien::class);
    }
    public function action(){
        return $this->belongsTo(Action::class);
    }
}
