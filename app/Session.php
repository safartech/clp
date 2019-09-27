<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    //

    public function epc(){
        return $this->hasMany('App\Epc');
    }

    public function avis(){
        return $this->hasMany(Avi::class);
    }

    public function obs(){
        return $this->hasMany(Observation::class);
    }

    public function observations(){
        return $this->hasMany(Observation::class);
    }




}
