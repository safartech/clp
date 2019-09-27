<?php

namespace App\Http\Controllers\Prof;

use App\Classe;
use App\EvaluationType;
use App\EvAquisition;
use App\EvNiveau;
use App\Intervention;
use App\Session;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class EvaluationController extends Controller
{
    //
    public function showNotesPage(){
        return view('espaces.prof.evaluations.notes');
    }

    public function showRelevesPage(){
        return view('espaces.prof.evaluations.releves');
    }

    public function showEpcPage(){
        return view('espaces.prof.evaluations.epc');
    }


    public function showBulletinsPage(){
        return view('espaces.prof.evaluations.bulletins');
    }

    public function loadNotesDatasFromProf(){
        $prof = User::find(Auth::id())->personnel;
        $interventions = Intervention::with(['prof','matieres.sousMatieres.modules','classe'])->where('personnel_id',$prof->id)->get();
        $iclasses = Intervention::with('classe.eleves')->distinct()->where('personnel_id',$prof->id)->get(['classe_id']);
        $imatieres = Intervention::with('matiere.sousMatieres.modules')->distinct()->where('personnel_id',$prof->id)->get(['matiere_id']);
        $sessions = Session::get();
//        $evals = Evaluation::with('classe.eleves.notes')->where('personnel_id',$prof->id)->get();

        $classes = [];
        $matieres = [];
        foreach ($iclasses as $iclass){ $classes[] = $iclass->classe ;}
//        foreach ($imatieres as $imatiere){ $matieres[] = $imatiere->matiere ;}

//        $all['evals'] = $evals;
        $all['interventions'] = $interventions;
        $all['sessions'] = $sessions;
        $all['classes'] = $classes;
//        $all['matieres'] = $matieres;
//        return $all;



        return compact('sessions','classes','interventions');
    }

    public function loadBulletinsDatasFromProf(){
        $id = Auth::id();
        $datas = User::with(['personnel.interventions.classe.eleves.evaluations','personnel.interventions.classe.eleves.absences','personnel.interventions.classe.eleves'=>function($q){$q->withCount('absences');}]
        )->find($id);
        $sessions = Session::with('avis','obs')->get();
        $all = [];
        $all["datas"] = $datas;
        $all["sessions"] = $sessions;
//        return $all;
        return compact('datas','sessions');
    }

    public function loadDatasForEpc(){
        $id = Auth::id();
        $datas = User::with('personnel.interventions.classe.eleves.competences',
            'personnel.interventions.classe.eleves.classe.niveau.matieres.domaines.competences',
            'personnel.interventions.classe.niveau.matieres.domaines.competences')
            ->find($id);
        $sessions = Session::get();
        $niveaux = EvNiveau::get();
        $acquis = EvAquisition::get();



        return compact('datas','niveaux','acquis','sessions');
    }
}
