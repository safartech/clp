<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Domaine extends Model
{

    public function competences(){
        return $this->hasMany('App\Competence');
    }

    public function matiere(){
        return $this->belongsTo('App\Matiere');
    }
}
