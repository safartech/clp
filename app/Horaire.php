<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Horaire extends Model
{

    public function cours(){
        return $this->hasMany(Cours::class);
    }
    
}
