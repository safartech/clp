<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Salle extends Model
{
    //
    protected $fillable = [];

    public function classe(){
        return $this->hasOne('App\Classe');
    }

    public function seances(){
        return $this->hasMany('App\Seance');
    }
}
