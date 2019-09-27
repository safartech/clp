<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Evaluation extends Model
{

    protected $guarded = ['id'];

    public function notes(){
        return $this->hasMany('App\Notation');
    }

    public function session(){
        return $this->belongsTo('App\Session');
    }

    public function classe(){
        return $this->belongsTo('App\Classe');
    }

    public function matiere(){
        return $this->belongsTo('App\Matiere');
    }

    public function sousMatiere(){
        return $this->belongsTo('App\SousMatiere');
    }
    public function module(){
        return $this->belongsTo('App\Module');
    }

    public function eleves(){
        return $this->belongsToMany('App\Eleve','notations','evaluation_id')->withPivot(['id','note']);
    }

}
