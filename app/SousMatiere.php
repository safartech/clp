<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class SousMatiere extends Model
{
    public function modules(){
        return $this->hasMany('App\Module');
    }

    public function matiere(){
        return $this->belongsTo('App\Matiere');
    }

    public function evaluations(){
        return $this->hasMany('App\Evaluation');
    }

    public function appreciations(){
        return $this->hasMany('App\Appreciation');
    }

    public function appreciation(){
        return $this->hasOne('App\Appreciation');
    }

    public function appres($sessionId,$eleveId){
        return $this->hasOne('App\Appreciation','sous_matiere_id')->where('session_id',$sessionId)->where('eleve_id',$eleveId)->first();
//        return $this->hasMany('App\Appreciation');
    }


}
