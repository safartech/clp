<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MatiereGroupe extends Model
{
    //

    protected $fillable = [];

    public function matieres(){
        return $this->hasMany('App\Matiere','groupe_id');
    }
}
