<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Attitude extends Model
{
    public function conduite(){
        return $this->belongsTo(Conduite::class);
    }

    public function avis(){
        return $this->hasMany(Avi::class,'attitude_id');
    }

}
