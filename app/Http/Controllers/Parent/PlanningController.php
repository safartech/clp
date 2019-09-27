<?php

namespace App\Http\Controllers\Parent;

use App\Classe;
use App\Cours;
use App\Eleve;
use App\Horaire;
use App\Jour;
use App\LienParente;
use App\Matiere;
use App\Personnel;
use App\Responsable;
use App\Salle;
use App\Seance;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PlanningController extends Controller
{
    public function showPlanningPage(){
        return view('espaces.parent.planning');
    }

    public function loadPlanningForParents(){
        $responsable_id= Auth::user()->responsable_id; //get the  responsable id
        $responsable=  Responsable::with('eleves.classe.cours.classe','eleves.classe.cours.jour','eleves.classe.cours.horaire','eleves.classe.cours.matiere','eleves.classe.cours.seances','eleves.classe.cours.salle','eleves.classe.cours.prof')->where('id',$responsable_id)->get();

        $profs = Personnel::with('cours.classe','cours.jour','cours.horaire','cours.matiere','cours.prof','cours.salle','cours.seances')->get();
        $jours = Jour::with('cours.classe','cours.matiere','cours.prof','cours.salle','cours.horaire')->get();
        $horaires = Horaire::get();
        $matieres = Matiere::get();
        $classes = Classe::with('cours.classe','cours.jour','cours.horaire','cours.matiere','cours.prof','cours.seances','eleves.responsables')->get();
        $salles = Salle::get();

        return compact('classes','jours','horaires','matieres','salles','responsable','profs');
    }

   /* public function storeCdt(Request $request){
        Seance::create($request->input());
        return 0;
    }

    public function loadClasseHoraire($classeId){
        $horaires = Horaire::with(['cours.classe'=>function($q) use ($classeId) {
            $q->where('id',$classeId);
        }])->get();

        return compact('horaires');
    }

    public function createCours(Request $request){
        $cours = Cours::create($request->input());
        $cours = Cours::with('classe','jour','horaire','matiere','prof','salle','seances')->find($cours->id);
//        $cours = Cours::with('matiere','prof','salle')->find($cours->id);
        return $cours;
    }*/


}


