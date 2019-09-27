<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dispense extends Model
{
    //
    protected $fillable = ['niveau_id','matiere_id','coef','note_max'];

    public function niveau(){
        $this->belongsTo('App\Niveau');
    }

    public function matiere(){
        $this->belongsTo('App\Matiere');
    }
}
