<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Module extends Model
{
    public function sousMatiere(){
        return $this->belongsTo('App\SousMatiere');
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
}
