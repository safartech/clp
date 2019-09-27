<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Epc extends Model
{
    protected $table = "epc";
    protected $fillable = ['eleve_id','competence_id','session_id','validation'];
}
