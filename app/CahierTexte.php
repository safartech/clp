<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CahierTexte extends Model
{
    //

    protected $fillable = ["contenu","seance_id","date","titre","validation","appel"];


    public function seance(){
        return $this->belongsTo('App\Seance');
    }

    public function tafs(){
        return $this->hasMany('App\Taf');
    }



}
