<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Jour extends Model
{

    public function cours(){
        return $this->hasMany('App\Cours');
    }
}
