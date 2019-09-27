<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Seance extends Model
{
    //
    protected $table = 'seances';

    protected $guarded = ['id'];

    public function taf(){
        return $this->hasOne(Taf::class);
    }

    public function matiere(){
        return $this->belongsTo('App\Matiere');
    }

    public function salle(){
        return $this->belongsTo('App\Salle');
    }

    public function classe(){
        return $this->belongsTo('App\Classe');
    }

    public function ctextes(){
        return $this->hasMany('App\CahierTexte');
    }

    public function categorie(){
        return $this->belongsTo('App\SeanceCategorie','categorie_id');
    }

    public function personnel(){
        return $this->belongsTo('App\Personnel');
    }

    public function appels(){
        return $this->hasMany('App\Appel');
    }

}
