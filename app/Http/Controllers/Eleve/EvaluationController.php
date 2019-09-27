<?php

namespace App\Http\Controllers\Eleve;

use App\Eleve;
use App\Evaluation;
use App\EvaluationType;
use App\Session;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class EvaluationController extends Controller
{
    //
    public function showNotesPage(){
        return view('espaces.eleve.evaluations.notes');
    }

    public function loadNotesDatasForEleve(){
        $sessions = Session::get();
        $types = EvaluationType::get();
        $eleve = Eleve::with('classe.niveau.matieres')->find(Auth::user()->eleve->id);
        $matieres = $eleve->classe->niveau->matieres;

        return compact('matieres','sessions','types');
    }

    public function loadEvaluations($matiereId,$sessionId){
        $eleveId = Auth::user()->eleve->id;
        $classeId = Auth::user()->eleve->classe_id;

        $evaluations = Evaluation::with([
            'type',
            'notes'=>function($q) use ($eleveId){
                $q->where('eleve_id',$eleveId);
            }
        ])->where('classe_id',$classeId)
            ->where('session_id',$sessionId)
            ->where('matiere_id',$matiereId)
            ->orderByDesc('id')
            ->get();

        return compact('evaluations');
    }
}
