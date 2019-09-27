<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Filiere extends Model
{
    //

    protected $fillable = [];

    public function niveaux(){
        return $this->hasMany('App\Niveau');
    }
}
