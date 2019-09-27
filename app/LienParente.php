<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LienParente extends Model
{
    //
    protected $fillable = ['responsable_id','eleve_id','lien_parente'];

    public function responsable(){
        return $this->belongsTo('App\Responsable');
    }

    public function eleve(){
        return $this->belongsTo('App\Eleve');
    }
}
