<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Information extends Model
{
    protected $table='informations';

    protected $fillable=[
      'title',
      'content',
      'start_date',
      'end_date'
    ];
}
