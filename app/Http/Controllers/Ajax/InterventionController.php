<?php

namespace App\Http\Controllers\Ajax;

use App\Classe;
use App\Intervention;
use App\Matiere;
use App\Personnel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;

class InterventionController extends Controller
{
    //
    public function loadInterventions(){
        $classes = Classe::with([
            'niveau.matieres'=>function($q){$q->orderBy('intitule');},
            'niveau.matieres.interventions.classe','niveau.matieres.interventions.matiere','niveau.matieres.interventions.prof'
        ])->get();
        $interventions = Intervention::with('classe','matiere','prof')->get();
        $profs = Personnel::whereHas('user',function($q){$q->where('role_id',10);})->orderBy('nom')->get();
        $matieres = Matiere::get();
        return compact('classes','interventions','profs','matieres');
    }

    public function setIntervention(Request $request){
        Intervention::updateOrCreate([
            'classe_id'=>$request->classe_id,
            'matiere_id'=>$request->matiere_id
        ],[
//            'matiere_id'=>$request->matiere_id,
            'personnel_id'=>$request->personnel_id,
        ]);

        return Response::HTTP_OK;
    }

    public function createMultiple(Request $request){
        return $request->input();
    }
}
