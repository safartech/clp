<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BasicController extends Controller
{
    //

    public function showInterventionsPage(){
        return view('espaces.protected.interventions');
    }

    public function showCoefPage(){
        return view('espaces.protected.coef');
    }

    public function showConseilPage(){
        return view('espaces.protected.conseil');
    }

    public function showRetardsPages(){
        return view('espaces.protected.retards');
    }


    public function showAbsencesPages(){
        return view('espaces.protected.absences');
    }
}
