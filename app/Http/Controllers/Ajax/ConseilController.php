<?php

namespace App\Http\Controllers\Ajax;

use App\Classe;
use App\Conseil;
use App\Responsable;
use App\Session;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ConseilController extends Controller
{
    //
    public function loadConseilDatas(){
        $sessions = Session::get();
//        $niveaux = Niveau::with('classes')->get();
        if (Auth::user()->role_id==10){
            $classes = Classe::with('eleves.conseils')->withCount('eleves')->where('personnel_id',Auth::user()->personnel_id)->get();
        }else{
            $classes = Classe::with('eleves.conseils')->withCount('eleves')->get();
        }
        $conseils = Conseil::get();
        return compact('classes','sessions','conseils');
    }

    public function setConseil(Request $request){
        Conseil::updateOrCreate([
            'session_id' => $request->session_id,
            'eleve_id' => $request->eleve_id,
        ],[
            'session_id' => $request->session_id,
            'eleve_id' => $request->eleve_id,
            'assiduite' => $request->assiduite,
            'conduite' => $request->conduite,
            'travail' => $request->travail,
            'retards' => $request->retards,
            'absences' => $request->absences,
            'ag' => $request->ag,
        ]);
        return "OK";
    }
}
