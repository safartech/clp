<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Matiere extends Model
{
    //

    protected $guarded=['id'];

    public function groupe(){
        return $this->belongsTo('App\MatiereGroupe');
    }

    public function profs(){
        return $this->belongsToMany('App\Personnel','enseignes','matiere_id','personnel_id');
    }

    public function niveaux(){
        return $this->belongsToMany('App\Niveau','dispenses','matiere_id','niveau_id');
    }

    public function eleves(){
        return $this->belongsToMany('App\Eleve','notations','matiere_id','eleve_id');
    }

    public function interventions(){
        return $this->hasMany('App\Intervention');
    }

    public function sousMatieres(){
        return $this->hasMany('App\SousMatiere');
    }

    public function evaluations(){
        return $this->hasMany('App\Evaluation');
    }

    public function domaines(){
        return $this->hasMany('App\Domaine');
    }

    public function appreciations(){
        return $this->hasMany('App\Appreciation');
    }

    public function appreciation(){
        return $this->hasOne('App\Appreciation');
    }

}
