<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Intervention extends Model
{

    public function prof(){
        return $this->belongsTo('App\Personnel','personnel_id');
    }

    public function matiere(){
        return $this->belongsTo('App\Matiere');
    }

    public function classe(){
        return $this->belongsTo('App\Classe');
    }

    public function matieres(){
        return $this->belongsToMany('App\Matiere','intervention_matiere');
    }
}
