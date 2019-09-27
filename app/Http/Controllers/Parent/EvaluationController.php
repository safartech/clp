<?php

namespace App\Http\Controllers\Parent;

use App\Classe;
use App\Eleve;
use App\Evaluation;
use App\EvaluationType;
use App\EvAquisition;
use App\EvNiveau;
use App\Responsable;
use App\Session;
use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class EvaluationController extends Controller
{

    public function showNotesPage(){
        return view('espaces.parent.evaluations.notes');
    }

    public function showRelevesPage(){
        return view('espaces.parent.evaluations.releves');
    }

    public function showEpcPage(){
        return view('espaces.parent.evaluations.epc');
    }

    public function showBulletinsPage(){
        return view('espaces.parent.evaluations.bulletins');
    }

    public function loadNotesDatasFromParent(){
        $parent = Responsable::with([
            'eleves.classe.niveau.matieres.sousMatieres.modules'
        ])->find(Auth::user()->responsable_id);

        $sessions = Session::get();
        $eleves = $parent->eleves;


        return compact('eleves','classes','sessions');
    }

    public function loadBulletinsDatasFromParent(){
        $responsable_id= Auth::user()->responsable_id; //get the  responsable id
        $responsable=  Responsable::with('eleves.classe')->where('id',$responsable_id)->find($responsable_id);
        $eleves = $responsable->eleves;
        $sessions = Session::get();
        return compact('eleves','sessions');
    }

    public function loadEvaluations($eleveId,$matiereId,$sessionId){
        $classe = Eleve::with('classe')->find($eleveId)->classe;

        $evaluations = Evaluation::with([
            'type',
            'notes'=>function($q) use ($eleveId){
            $q->where('eleve_id',$eleveId);
        }
        ])->where('classe_id',$classe->id)
            ->where('session_id',$sessionId)
            ->where('matiere_id',$matiereId)
            ->orderByDesc('id')
            ->get();

        return compact('evaluations');
    }


    public function loadEvaluationsForEleve($eleveId,$sessionId,$matiereId){
        $eleve = Eleve::find($eleveId);
        $evals = Evaluation::with(['notes'=>function($q) use ($eleveId){
            $q->where('eleve_id',$eleveId);
        }])->where('matiere_id',$matiereId)->where('session_id',$sessionId)->where('classe_id',$eleve->classe_id)->orderByDesc('id')->get();

        return compact('notes','evals');
    }
    public function loadEvaluationsOfSmForEleve($eleveId,$sessionId,$smId){
        $eleve = Eleve::find($eleveId);
        $evals = Evaluation::with(['notes'=>function($q) use ($eleveId){
            $q->where('eleve_id',$eleveId);
        }])->where('matiere_id',$smId)->where('session_id',$sessionId)->where('classe_id',$eleve->classe_id)->orderByDesc('id')->get();

        return compact('notes','evals');
    }

    public function loadEvaluationsOfModForEleve($eleveId,$sessionId,$moduleId){
        $eleve = Eleve::find($eleveId);
        $evals = Evaluation::with(['notes'=>function($q) use ($eleveId){
            $q->where('eleve_id',$eleveId);
        }])->where('matiere_id',$moduleId)->where('session_id',$sessionId)->where('classe_id',$eleve->classe_id)->orderByDesc('id')->get();

        return compact('notes','evals');
    }

    public function loadDatasForEpc(){
        $r = Responsable::with('eleves.competences','eleves.classe.niveau.matieres.domaines.competences')->find(Auth::user()->responsable_id);
        $eleves = $r->eleves;
        $sessions = Session::get();
        $niveaux = EvNiveau::get();
        $acquis = EvAquisition::get();

        return compact('eleves','niveaux','acquis','sessions');
    }

}
