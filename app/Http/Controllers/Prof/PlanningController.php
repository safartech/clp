<?php

namespace App\Http\Controllers\Prof;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PlanningController extends Controller
{
    //
    public function showClassePlanningPage(){
        return view('espaces.prof.planning.classe');
    }
    public function showProfPlanningPage(){
        return view('espaces.prof.planning.prof');
    }
}

