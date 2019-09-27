<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Conduite extends Model
{
    public function attitudes(){
        return $this->hasMany(Attitude::class);
    }

}
