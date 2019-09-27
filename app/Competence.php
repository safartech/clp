<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Competence extends Model
{
    public function eleves(){
        return $this->belongsToMany('App\Eleve','epc','competence_id')->withPivot(['id','validation','session_id']);
    }

    public function domaine(){
        return $this->belongsTo('App\Domaine');
    }

    public function epcs(){
        return $this->hasMany('App\Epc');
    }

}
