<?php

namespace App\Http\Controllers;

use App\Classe;
use App\Cours;
use App\Horaire;
use App\Jour;
use App\Matiere;
use App\Personnel;
use App\Salle;
use App\Seance;
use App\Taf;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PlanningController extends Controller
{
    //

    public function storeCdt(Request $request){
//        if($request->dm) return $request->dm['desc'] ;else return 0;
        $sc = Seance::create($request->cdt);
        /*if($request->dm){
            $dm = new Taf();
            $dm->desc = $request->dm['desc'];
            $dm->echeance = $request->dm['echeance'];
            $dm->seance_id = $sc->id;
            $dm->save();
        }*/
        return 1;
    }

    public function updateCdt(Request $request, $seanceId){
//        return $request->cdt;
        $s= Seance::find($seanceId);$s->update($request->cdt);
        return 200;
    }

    public function loadPlanningForClassesFromAdmin(){
        $classes = Classe::with('cours.classe','cours.jour','cours.horaire','cours.matiere','cours.prof','cours.salle','cours.seances')->get();
        $jours = Jour::with('cours.classe','cours.matiere','cours.prof','cours.salle','cours.horaire')->get();
        $horaires = Horaire::get();
        $matieres = Matiere::get();
        $profs = Personnel::get();
        $salles = Salle::get();

        return compact('classes','jours','horaires','matieres','profs','salles');
    }

    public function loadClasseHoraire($classeId){
        $horaires = Horaire::with(['cours.classe'=>function($q) use ($classeId) {
            $q->where('id',$classeId);
        }])->get();

        return compact('horaires');
    }

    public function createCours(Request $request){
//        $cours = Cours::create($request->input());
        $cours = Cours::updateOrCreate([
            'jour_id'=>$request->jour_id,
            'horaire_id'=>$request->horaire_id,
//            'classe_id'=>$request->classe_id,
            'personnel_id'=>$request->personnel_id,
        ],$request->input());
//        $cours = Cours::with('classe','jour','horaire','matiere','prof','salle','seances')->find($cours->id);
//        $cours = Cours::with('matiere','prof','salle')->find($cours->id);
        $c = Cours::with('classe','jour','horaire','matiere','prof','salle','seances')->find($cours->id);
        return $c;
    }

    public function updateCours(Request $request,$id){
        Cours::find($id)->update($request->input());
        return Response::HTTP_OK;
    }

    public function deleteCours($id){
        Cours::destroy([$id]);
        return 200;
    }


    // public function loadPlanningForProfsFromAdmin(){}
    //add by ken
    public function loadPlanningForProfsFromAdmin(){
        $profs = Personnel::with('cours.classe','cours.jour','cours.horaire','cours.matiere','cours.prof','cours.salle','cours.seances')->get();
        $jours = Jour::with('cours.classe','cours.matiere','cours.prof','cours.salle','cours.horaire')->get();
        $horaires = Horaire::get();
        $matieres = Matiere::get();
        $classes = Classe::with('cours.classe','cours.jour','cours.horaire','cours.matiere','cours.prof','cours.salle','cours.seances')->get();
        $salles = Salle::get();

        return compact('classes','jours','horaires','matieres','profs','salles');
    }

    public function loadProfHoraire($profId){
        $horaires = Horaire::with(['cours.prof'=>function($q) use ($profId) {
            $q->where('id',$profId);
        }])->get();

        return compact('horaires');
    }


    public function loadPlanningForSallesFromAdmin(){}
}
