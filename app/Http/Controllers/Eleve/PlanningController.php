<?php

namespace App\Http\Controllers\Eleve;

use App\Cours;
use App\Eleve;
use App\Horaire;
use App\Jour;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PlanningController extends Controller
{
    //
    public function showPlanningPage(){
        return view('espaces.eleve.planning.edt');
    }

    public function loadPlanningForEleve(){
        $eleve = Eleve::with('classe')->find(Auth::user()->eleve->id);
        $classe = $eleve->classe;
        $cours = Cours::with(
            'classe','jour','horaire','matiere','prof','salle','seances'
        )->where('classe_id',$eleve->classe_id)->get();
        $jours = Jour::with('cours.classe','cours.matiere','cours.prof','cours.salle','cours.horaire')->get();
        $horaires = Horaire::get();

        return compact('cours','jours','horaires','classe');
    }
}
