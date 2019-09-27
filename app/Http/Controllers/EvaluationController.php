<?php

namespace App\Http\Controllers;

use App\Absent;
use App\Appreciation;
use App\Classe;
use App\Conduite;
use App\Conseil;
use App\Eleve;
use App\Epc;
use App\Evaluation;
use App\Matiere;
use App\Module;
use App\Notation;
use App\Note;
use App\Observation;
use App\Session;
use App\SousMatiere;
use Dompdf\Dompdf;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\App;
use niklasravnsborg\LaravelPdf\Facades\Pdf;

class EvaluationController extends Controller
{
    //
    public function loadEvaluations($classeId,$matiereId,$sessionId){

        $eleves = Eleve::with(['evaluations'=>function($q) use ($classeId, $matiereId,$sessionId){
            $q->where('session_id',$sessionId)->where('matiere_id',$matiereId)->orderByDesc('id');
        }])->where('classe_id',$classeId)->get();

        $evaluations = Evaluation::with('type')->where('classe_id',$classeId)
            ->where('session_id',$sessionId)
            ->where('matiere_id',$matiereId)
            ->orderByDesc('id')
            ->get();

        return compact('eleves','evaluations');
    }

    public function deleteEvaluation($id){
        Evaluation::destroy([$id]);
        $notes = Notation::where('evaluation_id',$id)->get(['id']);
        $dels = [];
        foreach ($notes as $note){
            $dels[] = $note->id;
        }
        Notation::destroy($dels);
        return Response::HTTP_OK;
    }

    public function updateEvaluation($id,Request $request){
        Evaluation::find($id)->update($request->input());
        return 200;
    }

    public function createEvaluation(Request $request){
//        $ev = Evaluation::updateOrCreate(['date'=>$request->date],$request->input());
        $ev = Evaluation::create($request->input());
//        $eleves = Eleve::with('notes')->get();
//        $classe = Classe::with(['evaluation','eleves'])->get();
        $eval = Evaluation::with('classe.eleves')->find($ev->id);

        foreach ($eval->classe->eleves as $eleve){
            $eval->eleves()->attach($eleve->id,['note'=>null]);
            if ($eval->module_id){
                Appreciation::updateOrCreate([
                    'classe_id'=>$eval->classe_id,
                    'session_id'=>$eval->session_id,
                    'eleve_id'=>$eleve->id,
                    'module_id'=>$eval->module_id
                ]);
            }else if ($eval->sous_matiere_id){

                Appreciation::updateOrCreate([
                    'eleve_id'=>$eleve->id,
                    'session_id'=>$eval->session_id,
                    'classe_id'=>$eval->classe_id,
                    'sous_matiere_id'=>$eval->sous_matiere_id
                ]);
            }else if ($eval->matiere_id){
                Appreciation::updateOrCreate([
                    'eleve_id'=>$eleve->id,
                    'session_id'=>$eval->session_id,
                    'classe_id'=>$eval->classe_id,
                    'matiere_id'=>$eval->matiere_id
                ]);
            }
        }
        return $eval;
    }

    public function updateNote(Request $request){
        $notation = Notation::find($request->id);
        $notation->update($request->input());
        return $notation;
    }

    public function evaluate(Request $request){

//        return $request->session_id;
        $epc = Epc::where('eleve_id',$request->eleve_id)
            ->where('competence_id',$request->competence_id)
            ->where('session_id',$request->session_id )->first();
        if($epc){
            $epc->update($request->input());
            $eleve = Eleve::with('competences')->find($request->eleve_id);
            return $eleve;
        }else{
            Epc::create($request->input());
            $eleve = Eleve::with('competences')->find($request->eleve_id);
            return  $eleve;
        }
//        $eleve->competences()->sync([$request->competence_id => ['session_id'=>$request->session_id,'validation'=>$request->validation]]);
    }

    public function loadElevesNotes($eleveId,$sessionId){
        $e = Eleve::with('conseils')->find($eleveId);
        $classeId = $e->classe_id;
        $conseils = $e->conseils;
        $classe = Classe::with([

            'niveau.matieres'=>function($q){$q->orderBy('ordre');},
            'niveau.matieres.evaluations'=>function($q) use ($classeId, $sessionId){ $q->where('classe_id',$classeId)->where('session_id',$sessionId)->where('sous_matiere_id',null);},
            'niveau.matieres.sousMatieres.evaluations'=>function($q) use ($classeId, $sessionId){ $q->where('classe_id',$classeId)->where('session_id',$sessionId)->where('module_id',null);},
            'niveau.matieres.sousMatieres.modules.evaluations'=>function($q) use ($classeId, $sessionId){ $q->where('classe_id',$classeId)->where('session_id',$sessionId);},

            'niveau.matieres.evaluations.notes'=>function($q) use ($eleveId){ $q->where('eleve_id',$eleveId); },
            'niveau.matieres.sousMatieres.evaluations.notes'=>function($q) use ($eleveId){ $q->where('eleve_id',$eleveId); },
            'niveau.matieres.sousMatieres.modules.evaluations.notes'=>function($q) use ($eleveId){ $q->where('eleve_id',$eleveId); },

            'niveau.matieres.appreciations'=>function($q) use ($eleveId,$sessionId){ $q->where('eleve_id',$eleveId)->where('session_id',$sessionId)->where('sous_matiere_id',null);},
            'niveau.matieres.sousMatieres.appreciations'=>function($q) use ($eleveId,$sessionId){ $q->where('eleve_id',$eleveId)->where('session_id',$sessionId)->where('module_id',null);},
            'niveau.matieres.sousMatieres.modules.appreciations'=>function($q) use ($eleveId,$sessionId){ $q->where('eleve_id',$eleveId)->where('session_id',$sessionId);},

            'niveau.conduites.attitudes.avis'=>function($q) use ($eleveId,$sessionId){ $q->where('eleve_id',$eleveId)->where('session_id',$sessionId);},

        ])->find($classeId);

        $obs = Observation::where('eleve_id',$eleveId)->where('session_id',$sessionId)->get();
        $abs = Absent::where('eleve_id',$eleveId)->where('session_id',$sessionId)->first();
        $matieres = $classe->niveau->matieres;
        $conduites = $classe->niveau->conduites;

        return compact('matieres','conduites','obs','abs','conseils');
    }

    public function setConseil(Request $request){
        Conseil::updateOrCreate([
            'session_id' => $request->session_id,
            'eleve_id' => $request->eleve_id,
        ],
            $request->input());
        return "OK";
    }

    public function printBulletin($eleveId,$sessionId){
//        dd($sessionId);
        //Have to come as parameter
//        $eleveId = 16;
//        $sessionId = 1;
//        dd($eleveId);
        $eleve = Eleve::with('classe.prof','absences')->find($eleveId);
        $conseil = Conseil::where('eleve_id',$eleveId)->where('session_id',$sessionId)->first();
//        dd($conseil);
        $session = Session::find($sessionId);
        $classe = $eleve->classe;
        $classeId = $classe->id;
        $c = Classe::with([
            'niveau.matieres'=>function($q){$q->orderBy('ordre');},

            'niveau.matieres.evaluations'=>function($q) use ($sessionId,$classeId) {
                $q->where('session_id',$sessionId)->where('classe_id',$classeId)->where('sous_matiere_id',null);
            },
            'niveau.matieres.evaluations.notes'=>function($q) use($eleveId){
                $q->where('eleve_id',$eleveId);
            },
            'niveau.matieres.appreciations'=>function($q) use ($sessionId, $eleveId){
                $q->where('session_id',$sessionId)->where('eleve_id',$eleveId);
            },

            'niveau.matieres.sousMatieres.evaluations' => function($q) use($sessionId,$classeId){
                $q->where('session_id',$sessionId)->where('classe_id',$classeId)->where('module_id',null);
            },
            'niveau.matieres.sousMatieres.evaluations.notes'=>function($query) use ($eleveId){
                $query->where('eleve_id',$eleveId);
            },
            'niveau.matieres.sousMatieres.appreciations'=>function($q) use ($sessionId, $eleveId){
                $q->where('session_id',$sessionId)->where('eleve_id',$eleveId);
            },


            'niveau.matieres.sousMatieres.modules.evaluations'=>function($q) use($sessionId,$classeId){
                $q->where('session_id',$sessionId)->where('classe_id',$classeId);
            },
            'niveau.matieres.sousMatieres.modules.evaluations.notes'=>function($q) use ($eleveId){
                $q->where('eleve_id',$eleveId);
            },
            'niveau.matieres.sousMatieres.modules.appreciations'=>function($q) use ($sessionId, $eleveId){
                $q->where('session_id',$sessionId)->where('eleve_id',$eleveId);
            },

        ])->withCount('eleves')->find($classeId);

//        dd($c->niveau->matieres);

        $matieres = $c->niveau->matieres;

        $tab_mats_moys = [];
        $list_des_moyennes_de_matieres = [];
        foreach ($matieres as $matiere){
            if (count($matiere->sousMatieres)==0){
                $moy = 0;
                $pas_de_note = 0;
                $total = 0;
                $nbre_ev = count($matiere->evaluations);
                $notes = [];

                foreach ($matiere->evaluations as $evaluation){

                    if($nbre_ev>0)
                        $n = $evaluation->notes[0]->note;
                    /*foreach ($evaluation->notes as $l=> $note){
                     $n = $note->note;
                    }*/

                    if (is_numeric($n)){
                        $total+=$n;
                        $notes[] = $n;
                    }
                }
                if(count($notes)>0){
                    $moy = $total/count($notes);
                    $matiere['moy']=$moy;
                    if(is_numeric($moy)){
                        $list_des_moyennes_de_matieres[] = round($moy);
                    }

                }


            }else{

            }









        }





        /*$matieres = Matiere::with(['evaluations'=>function($q) use($sessionId){
            $q->where('session_id',$sessionId);
        },'evaluations.notes'=>function($query) use ($eleveId){
            $query->where('eleve_id',$eleveId);
        },
            'appreciation'=>function($q) use ($sessionId, $eleveId){
            $q->where('session_id',$sessionId)->where('eleve_id',$eleveId);
            },
            'sousMatieres.evaluations'=>function($q) use($sessionId){
                $q->where('session_id',$sessionId);
            },
            'sousMatieres.evaluations.notes'=>function($query) use ($eleveId){
                $query->where('eleve_id',$eleveId);
            },

            'sousMatieres.appreciation'=>function($q) use ($sessionId, $eleveId){
                $q->where('session_id',$sessionId)->where('eleve_id',$eleveId);
            },
            'sousMatieres.modules.evaluations'=>function($q) use($sessionId){
                $q->where('session_id',$sessionId);
            },
            'sousMatieres.modules.evaluations.notes'=>function($query) use ($eleveId){
                $query->where('eleve_id',$eleveId);
            },
            'sousMatieres.modules.appreciation'=>function($q) use ($sessionId, $eleveId){
                $q->where('session_id',$sessionId)->where('eleve_id',$eleveId);
            },
            ])->get();*/
//        dd($matieres);

        $MATIERES = Matiere::with(['evaluations'=>function($q) use ($classeId,$sessionId){
            $q->where('classe_id',$classeId)->where('session_id',$sessionId)->where('sous_matiere_id',null);
        },
            'evaluations.notes',

            'sousMatieres.evaluations'=>function($query) use ($classeId,$sessionId){
                $query->where('classe_id',$classeId)->where('session_id',$sessionId)->where('module_id',null);
            },
            'sousMatieres.evaluations.notes',
            'sousMatieres.modules.evaluations'=>function($query) use ($classeId,$sessionId){
                $query->where('classe_id',$classeId)->where('session_id',$sessionId);
            },
            'sousMatieres.modules.evaluations.notes'
        ])->get();

        $MOY = 0;
        $MAT_MOYS = [];
        foreach ($MATIERES as $MATIERE){
            if(count($MATIERE->sousMatieres)==0){
                $evaluations_moys = [];
                foreach ($MATIERE->evaluations as $evaluation){
                    $total_des_notes_des_eleves_sur_l_evaluation = 0;
                    foreach ($evaluation->notes as $note){
                        $total_des_notes_des_eleves_sur_l_evaluation +=$note->note;
                    }
                    $moy_classe_on_eval = $total_des_notes_des_eleves_sur_l_evaluation/$c->eleves_count;
                    $evaluations_moys[] = $moy_classe_on_eval;
                }
                if (count($evaluations_moys)!=0)
                    $MAT_MOYS[] = array_sum($evaluations_moys)/count($evaluations_moys);
                else{
                    $MAT_MOYS[] = 0;
                }
            }else{
                $SM_MOYS = [];
                foreach ($MATIERE->sousMatieres as $sousMatiere){
                    if(count($sousMatiere->modules)==0){
                        $evaluations_moys = [];
                        foreach ($sousMatiere->evaluations as $evaluation){
                            $total_des_notes_des_eleves_sur_l_evaluation = 0;
                            foreach ($evaluation->notes as $note){
                                $total_des_notes_des_eleves_sur_l_evaluation +=$note->note;
                            }
                            $moy_classe_on_eval = $total_des_notes_des_eleves_sur_l_evaluation/$c->eleves_count;
                            $evaluations_moys[] = $moy_classe_on_eval;
                        }
                        if (count($evaluations_moys)!=0)
                            $SM_MOYS[] = array_sum($evaluations_moys)/count($evaluations_moys);
                        else{
                            $SM_MOYS[] = 0;
                        }

                    }else{
                        $MOD_MOYS = [];
                        foreach ($sousMatiere->modules as $module){
                            $evaluations_moys = [];
                            foreach ($module->evaluations as $evaluation){
                                $total_des_notes_des_eleves_sur_l_evaluation = 0;
                                foreach ($evaluation->notes as $note){
                                    $total_des_notes_des_eleves_sur_l_evaluation +=$note->note;
                                }
                                $moy_classe_on_eval = $total_des_notes_des_eleves_sur_l_evaluation/$c->eleves_count;
                                $evaluations_moys[] = $moy_classe_on_eval;
                            }
                            if (count($evaluations_moys)!=0)
                                $MOD_MOYS[] = array_sum($evaluations_moys)/count($evaluations_moys);
                            else{
                                $MOD_MOYS[] = 0;
                            }
                        }
                        if(count($MOD_MOYS)!=0)
                            $SM_MOYS[] = array_sum($MOD_MOYS)/count($MOD_MOYS);
                        else $SM_MOYS[] = 0;

                    }

                }
                if(count($SM_MOYS)!=0)
                    $MAT_MOYS[] = array_sum($SM_MOYS)/count($SM_MOYS);
                else{
                    $MAT_MOYS[] = 0;
                }
            }
        }

        $MOY = array_sum($MAT_MOYS)/count($MAT_MOYS);
        $MOY = round($MOY,2);
        $moyenneClasse = $MOY;

        $conduites = Conduite::with(['attitudes.avis'=>function($q) use ($eleveId,$sessionId){
            $q->where('eleve_id',$eleveId)->where('session_id',$sessionId);
        }])->get();

        $obs = Observation::where('eleve_id',$eleveId)->where('session_id',$sessionId)->get();
        $abs = Absent::where('eleve_id',$eleveId)->where('session_id',$sessionId)->first();

        $prof = $classe->prof;

//        return view('templates.bulletins.modele_1',compact('conseil','matieres','moyenneClasse','session', 'eleve','conduites','obs','abs','prof','classe'));

        $pdf = App::make('dompdf.wrapper');
//        $pdf->loadHTML('<h1>Test</h1>');
        $pdf->loadView('templates.bulletins.modele_1', compact("conseil",'matieres','moyenneClasse','session', 'eleve','conduites','obs','abs','prof','classe'));
//        return $pdf->download($eleve->nom_complet.' - Bulletin'.'.pdf');
        return $pdf->stream($eleve->nom_complet.' - Bulletin'.'.pdf');
//        return $pdf->stream();



    }


    public function printEpc($eleveId){
        $eleve = Eleve::with('competences')->find($eleveId);
        $matieres = Matiere::with(['domaines.competences.epcs'=>function($q) use ($eleveId){
            $q->where('eleve_id',$eleveId)->orderBy('session_id');
        }])->whereHas('domaines')->get();
        $sessions = Session::get();
        $classe = Classe::with('eleves')->find($eleve->classe_id);

//        return view("templates.epc.model0",compact('eleve','matieres','classe','sessions'));

        $pdf = App::make('dompdf.wrapper');
//        $pdf->loadHTML('<h1>Test</h1>');
        $pdf->loadView('templates.epc.model0', compact('eleve','matieres','classe','sessions'));
        return $pdf->download($eleve->nom_complet.' - EPC'.'.pdf');
    }


    public function printEleveReleve($eleveId,$sessionId){
        $eleve = Eleve::with(['classe.niveau','classe.eleves'])->find($eleveId);
        $classe = $eleve->classe;
        $classeId = $classe->id;
        $niveau  = $classe->niveau;
        $session = Session::find($sessionId);
        $matieres = Matiere::with(['evaluations'=>function($q) use ($sessionId, $classeId){$q->where('classe_id',$classeId)->where('session_id',$sessionId)->where('sous_matiere_id',null);},
            'evaluations.notes'=>function($q) use ($eleveId){
            $q->where('eleve_id',$eleveId);
        },
            'sousMatieres.evaluations'=>function($q) use ($sessionId, $classeId){$q->where('classe_id',$classeId)->where('session_id',$sessionId)->where('module_id',null);},
            'sousMatieres.evaluations.notes'=>function($q) use ($eleveId){
                $q->where('eleve_id',$eleveId);
            },
//            'sousMatieres'=>function($q){ $q->withCount('evaluations');},
            'sousMatieres.modules.evaluations'=>function($q) use ($sessionId, $classeId){$q->where('classe_id',$classeId)->where('session_id',$sessionId);},
            'sousMatieres.modules.evaluations.notes'=>function($q) use ($eleveId){
                $q->where('eleve_id',$eleveId);
            },
//            'sousMatieres.modules'=>function($q){ $q->withCount('evaluations');},
        ])->whereHas('niveaux',function ($q) use ($niveau){
            $q->where('niveau_id',$niveau->id);
        })->withCount("evaluations")->orderBy('ordre')->get();
        /*$sousMatieres = SousMatiere::with([
            'evaluations'=>
            function($q) use ($sessionId, $classeId){$q->where('classe_id',$classeId)->where('session_id',$sessionId)->where('module_id',null);}
        ])->get();
        $modules = Module::with([
            'evaluations'=>
            function($q) use ($sessionId, $classeId){$q->where('classe_id',$classeId)->where('session_id',$sessionId);}
        ])->get();*/

//        dd($matieres);
        $count = 0;
        foreach ($matieres as $m){
            if(count($m->sousMatieres)==0){
                $count = ($count<=count($m->evaluations))?count($m->evaluations):$count;
            }else{
                foreach ($m->sousMatieres as $sm){
                    if(count($sm->modules)==0){
                        $count = ($count<=count($sm->evaluations))?count($sm->evaluations):$count;
                    }else{
                        foreach ($sm->modules as $mod){
                            $count = ($count<=count($mod->evaluations))?count($mod->evaluations):$count;
                        }
                    }
                }
            }
        }
//        dd($count);



//        return view('templates.releves.eleve',compact('matieres','session','eleve', "count"));


//        $pdf = Pdf::loadView('templates.releves.eleve', compact('matieres','session','eleve', "count"));
//        return $pdf->stream('document.pdf');

        $pdf = App::make('dompdf.wrapper');
//        $pdf->loadHTML('<h1>Test</h1>');
        $pdf->loadView('templates.releves.eleve', compact('matieres','session','eleve', "count"));
//        return $pdf->download($eleve->nom_complet." - Relevé ".$session->nom.'.pdf');
        return $pdf->stream($eleve->nom_complet." - Relevé ".$session->nom.'.pdf');


    }

    public function printClasseModuleReleve($classeId, $sessionId, $moduleId){
        $evals = Evaluation::with('eleves')->where('classe_id',$classeId)->where('module_id', $moduleId)->where('session_id',$sessionId)->orderByDesc('id')->get();
        $classe = Classe::with(['eleves.evaluations'=>function($q) use ($moduleId, $sessionId){
            $q->where('module_id',$moduleId)->where('session_id',$sessionId)->orderByDesc('id');
        },

            'eleves.appreciation'=>function($q) use ($moduleId,$sessionId){
                $q->where('module_id',$moduleId)->where('session_id',$sessionId);
            }

        ])->find($classeId);
        $eleves = $classe->eleves;
        $module = Module::with('sousMatiere.matiere')->find($moduleId);
        $session = Session::find($sessionId);

//        return view('templates.releves.classe.module',compact('evals','eleves','classe','module','session'));

        $pdf = App::make('dompdf.wrapper');
//        $pdf->loadHTML('<h1>Test</h1>');
        $pdf->loadView('templates.releves.classe.module', compact('evals','eleves','classe','module','session'));
        return $pdf->download($classe->nom." - ".$module->nom.'.pdf');
    }

    public function printClasseSMReleve($classeId, $sessionId, $smId){
        $evals = Evaluation::with('eleves')->where('classe_id',$classeId)->where('sous_matiere_id',$smId)->where('session_id',$sessionId)->orderByDesc('id')->get();
        $classe = Classe::with(['eleves.evaluations'=>function($q) use ($smId, $sessionId){
            $q->where('sous_matiere_id',$smId)->where('session_id',$sessionId)->orderByDesc('id');
        },
            'eleves.appreciation'=>function($q) use ($smId,$sessionId){
                $q->where('sous_matiere_id',$smId)->where('session_id',$sessionId);
            }

        ])->find($classeId);
        $eleves = $classe->eleves;
        $sm = SousMatiere::with('matiere')->find($smId);
        $session = Session::find($sessionId);

//        return view('templates.releves.classe.sm',compact('evals','eleves','classe','sm','session'));

        $pdf = App::make('dompdf.wrapper');
//        $pdf->loadHTML('<h1>Test</h1>');
        $pdf->loadView('templates.releves.classe.sm', compact('evals','eleves','classe','sm','session'));
        return $pdf->download($classe->nom." - ".$sm->nom.'.pdf');
    }

    public function printClasseMatiereReleve($classeId, $sessionId, $matiereId){
        $evals = Evaluation::with('eleves')->where('classe_id',$classeId)->where('matiere_id',$matiereId)->where('session_id',$sessionId)->orderByDesc('id')->get();
        $classe = Classe::with(['eleves.evaluations'=>function($q) use ($matiereId, $sessionId){
            $q->where('matiere_id',$matiereId)->where('session_id',$sessionId)->orderByDesc('id');
        },
            'eleves.appreciation'=>function($q) use ($matiereId,$sessionId){
                $q->where('matiere_id',$matiereId)->where('session_id',$sessionId);
            }

        ])->find($classeId);
        $eleves = $classe->eleves;
        $matiere = Matiere::find($matiereId);
        $session = Session::find($sessionId);

//        return view('templates.releves.classe.matiere',compact('evals','eleves','classe','matiere','session'));

        $pdf = App::make('dompdf.wrapper');
//        $pdf->loadHTML('<h1>Test</h1>');
        $pdf->loadView('templates.releves.classe.matiere', compact('evals','eleves','classe','matiere','session'));
        return $pdf->download($classe->nom." - ".$matiere->intitule.'.pdf');
    }


}
