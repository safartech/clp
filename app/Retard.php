<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Retard extends Model
{
    protected $guarded = ['id'];

    public function eleve(){
        return $this->belongsTo(Eleve::class);
    }
}
