<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Classe extends Model
{
    //
    protected $fillable = [];

    public function niveau(){
        return $this->belongsTo('App\Niveau','niveau_id');
    }

    public function eleves(){
        return $this->hasMany('App\Eleve')->orderBy('nom_complet');
    }

    public function salle(){
        return $this->belongsTo('App\Salle');
    }

    public function seances(){
        return $this->hasMany('App\Seance');
    }

    public function profs(){
        return $this->belongsToMany('App\Personnel','interventions','classe_id','personnel_id');
    }

    public function interventions(){
        return $this->hasMany('App\Intervention');
    }


    public function evaluations(){
        return $this->hasMany('App\Evaluation');
    }

    /*public function salleId(){
        return $this->belongsTo('App\Salle');
    }*/

    public function prof(){
        return $this->belongsTo(Personnel::class,'personnel_id');
    }

    public function cours(){
        return $this->hasMany('App\Cours');
    }
}
