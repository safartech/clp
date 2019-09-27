<?php

namespace App\Http\Controllers\Admin;

use App\Appreciation;
use App\Classe;
use App\Evaluation;
use App\EvAquisition;
use App\EvNiveau;
use App\Matiere;
use App\Eleve;
use App\EvaluationType;
use App\Session;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EvaluationController extends Controller
{
    //


    public function showNotesPage(){
        return view('espaces.admin.evaluations.notes');
    }

    public function showEpcPage(){
        return view('espaces.admin.evaluations.epc');
    }

    public function showRelevesPage(){
        return view('espaces.admin.evaluations.releves');
    }

    public function showComposPage(){
        return view('espaces.admin.evaluations.compos');
    }


    public function showBulletinsPage(){
        return view('espaces.admin.evaluations.bulletins');
    }


    /******************************AJAX*************/

    public function loadReleveesDatasFromAdmin(){
        $classes = Classe::with('eleves','niveau.matieres')->get();
        $sessions = Session::get();
        return compact('classes','sessions');
    }

    public function loadNotesDatasFromAdmin(){
        $classes = Classe::with([
            'niveau.matieres.sousMatieres.modules',
            'eleves'
            ])->get();
        $sessions = Session::get();
//        $types = EvaluationType::get();

        return compact('classes','sessions','types');
    }

    public function loadEvaluationsOfMod($classeId,$sessionId,$moduleId){
        $evals = Evaluation::with('eleves')->where('classe_id',$classeId)->where('module_id', $moduleId)->where('session_id',$sessionId)->orderByDesc('id')->get();
        $c = Classe::with(['eleves.evaluations'=>function($q) use ($moduleId, $sessionId){
            $q->where('module_id',$moduleId)->where('session_id',$sessionId)->orderByDesc('id');
        },

            'eleves.appreciations'=>function($q) use ($moduleId,$sessionId){
                $q->where('module_id',$moduleId)->where('session_id',$sessionId);
            }

        ])->find($classeId);
        $eleves = $c->eleves;
//        $appreciations = Appreciation::where('classe_id',$classeId)->where('module_id',$moduleId)->where('session_id',$sessionId)->get();
        $ecos = [];
        $ecos['evals'] = $evals;
        $ecos['eleves'] = $eleves;
//        $ecos['appreciations']= $appreciations;
        /*foreach ($c->eleves as $i=> $eleve){
            $ecos[$i] =[
                "eleve" => $eleve,
                "notes" => $eleve->notes
            ];
        }*/

        return $ecos;
    }

    public function loadEvaluationsOfSm($classeId,$sessionId,$smId){
        $evals = Evaluation::with('eleves')->where('classe_id',$classeId)->where('sous_matiere_id',$smId)->where('session_id',$sessionId)->orderByDesc('id')->get();
        $c = Classe::with(['eleves.evaluations'=>function($q) use ($smId, $sessionId){
            $q->where('sous_matiere_id',$smId)->where('session_id',$sessionId)->orderByDesc('id');
        },
            'eleves.appreciations'=>function($q) use ($smId,$sessionId){
                $q->where('sous_matiere_id',$smId)->where('session_id',$sessionId);
            }

        ])->find($classeId);
        $eleves = $c->eleves;

//        $appreciations = Appreciation::where('classe_id',$classeId)->where('sous_matiere_id',$smId)->where('session_id',$sessionId)->get();
        $ecos = [];
        $ecos['evals'] = $evals;
        $ecos['eleves'] = $eleves;
//        $ecos['appreciations']= $appreciations;
        /*foreach ($c->eleves as $i=> $eleve){
            $ecos[$i] =[
                "eleve" => $eleve,
                "notes" => $eleve->notes
            ];
        }*/

        return $ecos;
    }

    public function loadEvaluations($classeId,$sessionId,$matiereId){

        $evals = Evaluation::with('eleves')->where('classe_id',$classeId)->where('matiere_id',$matiereId)->where('session_id',$sessionId)->orderByDesc('id')->get();
        $c = Classe::with(['eleves.evaluations'=>function($q) use ($matiereId, $sessionId){
            $q->where('matiere_id',$matiereId)->where('session_id',$sessionId)->orderByDesc('id');
        },
            'eleves.appreciations'=>function($q) use ($matiereId,$sessionId){
                $q->where('matiere_id',$matiereId)->where('session_id',$sessionId);
            }

        ])->find($classeId);
        $eleves = $c->eleves;
//        $appreciations = Appreciation::where('classe_id',$classeId)->where('matiere_id',$matiereId)->where('session_id',$sessionId)->get();
        $ecos = [];
        $ecos['evals'] = $evals;
        $ecos['eleves'] = $eleves;
//        $ecos['appreciations'] = $appreciations;
        /*foreach ($c->eleves as $i=> $eleve){
            $ecos[$i] =[
                "eleve" => $eleve,
                "notes" => $eleve->notes
            ];
        }*/

        return $ecos;

    }

    public function setAppreciation(Request $request){
        $a = Appreciation::find($request->id);
        $a->update($request->input());
        return $a->appreciation;
    }


    public function loadDatasForEpc(){

        $classes = Classe::with('eleves.competences','eleves.classe.niveau.matieres.domaines.competences','niveau.matieres.domaines.competences')->get();
        $sessions = Session::get();
        $niveaux = EvNiveau::get();
        $acquis = EvAquisition::get();

        return compact('classes','niveaux','acquis','sessions');
    }




    public function loadBulletinsDatasFromAdmin(){
        $classes = Classe::with('eleves.evaluations')->get();
        $sessions = Session::get();
        return compact('classes','sessions');

    }

    public function loadBulletinOfEleveFromAdmin($eleveId,$sessionId){
        $z=0;
//        return $z;
        $eleve = Eleve::with('classe.prof')->find($eleveId);
//        return $eleve->nom_complet;
        $classe = $eleve->classe;
        $prof = $classe->prof;
//        dd($prof);
        $classeId = $classe->id;
        $niveauId = $classe->niveau_id;
        $MATIERES = Matiere::with([
                'dispenses'=>function($q) use ($niveauId) { $q->where('niveau_id',$niveauId); },
                'appreciations'=>function($q) use ($eleveId,$sessionId){
                    $q->where('eleve_id',$eleveId)->where('session_id',$sessionId);
                },
                /*'evaluations'=>function($q) use ($classeId,$sessionId){
//            $q->where('classe_id',$classeId)->where('take',1);
                    $q->where('classe_id',$classeId)->where('session_id',$sessionId);
                },*/
                /*'evaluations.notes'=>function($q) use ($eleveId){
                    $q->where('eleve_id',$eleveId);
                },*/
//                'interros'=>function($q){ $q->where('take',1);},
                // apparamment inutile=> filtre depuis evaluations
                'interros'=>function($q) use ($classeId){ $q->where('classe_id',$classeId); },
                'ds'=>function($q) use ($classeId){ $q->where('classe_id',$classeId); },
                'compos'=>function($q) use ($classeId){ $q->where('classe_id',$classeId); },
                'compos.notes' => function($q) use ($eleveId){ $q->where('eleve_id',$eleveId); },
                'interros.notes' => function($q) use ($eleveId){ $q->where('eleve_id',$eleveId); },
                'ds.notes' => function($q) use ($eleveId){ $q->where('eleve_id',$eleveId); },
                'interventions',
                "interventions.prof"
            ]
        )->whereHas('niveaux',function($q) use ($niveauId){
            $q->where('niveau_id',$niveauId);
        })->orderBy('id')->get();
//        dd($MATIERES[0]->dispenses);

        $eleves = Eleve::where('classe_id',$classeId)->get();
        $gen_moys_of_eleves = [];
        $moyennes_de_l_eleves_dans_chaque_matiere = [];
        foreach ($eleves as $elv){
            $moy_gen_of_eleve = 0;
//            $moys_of_eleve = [];
            $eId = $elv->id;
//            dd($eId);
            $eMatieres = Matiere::with([
                    'dispenses'=>function($q) use ($niveauId) { $q->where('niveau_id',$niveauId); },
                    /*'evaluations'=>function($q) use ($classeId,$sessionId){
//            $q->where('classe_id',$classeId)->where('take',1);
                        $q->where('classe_id',$classeId)->where('session_id',$sessionId);
                    },
                    'evaluations.notes'=>function($q) use ($eId){
                        $q->where('eleve_id',$eId);
                    },*/
//                'interros'=>function($q){ $q->where('take',1);},
                    // apparamment inutile=> filtre depuis evaluations
                    'interros'=>function($q) use ($classeId){ $q->where('classe_id',$classeId); },
                    'ds'=>function($q) use ($classeId){ $q->where('classe_id',$classeId); },
                    'compos'=>function($q) use ($classeId){ $q->where('classe_id',$classeId); },
                    'compos.notes' => function($q) use ($eId){ $q->where('eleve_id',$eId); },
                    'interros.notes' => function($q) use ($eId){ $q->where('eleve_id',$eId); },
                    'ds.notes' => function($q) use ($eId){ $q->where('eleve_id',$eId); },
                ]
            )->whereHas('niveaux',function($q) use ($niveauId){
                $q->where('niveau_id',$niveauId);
            })->orderBy('id')->get();

            $moys = [];
            $moys_obs = [];
            $moys_facs = [];
            foreach ($eMatieres as $i=>$matiere){
                $interros_notes=[];
                $ds_notes=[];
                $compos_notes=[];
                // récupération des notes d'interrogations
                foreach ($matiere->interros as $interro){
                    if (count($interro->notes)>0){
                        if(is_numeric($interro->notes[0]->note)){
                            $interros_notes[] = $interro->notes[0]->note;
                        }
                    }
                }
                if(count($interros_notes)>0){
//                dd(array_sum($interros_notes));
                    $matiere["note_interro"] = number_format(array_sum($interros_notes)/count($interros_notes),2);
                }else{
                    $matiere["note_interro"] = "";
                }

                //récupétration des notes de devoirs sureillés
                foreach ($matiere->ds as $devoir){
                    if (count($devoir->notes)>0){
                        if(is_numeric($devoir->notes[0]->note)){
                            $ds_notes[] = $devoir->notes[0]->note;
                        }
                    }
                }
                if(count($ds_notes)>0){
                    $matiere["note_ds"] = number_format(array_sum($ds_notes)/count($ds_notes),2);
                }else{
                    $matiere["note_ds"] = "";
                }

                //calcul moyenne classe
                if(is_numeric($matiere["note_interro"]) && is_numeric($matiere["note_ds"]))
                    $matiere["note_classe"] = ($matiere["note_interro"] + $matiere["note_ds"])/2;
                elseif (is_numeric($matiere["note_ds"])) $matiere["note_classe"] = $matiere["note_interro"];
                elseif (is_numeric($matiere["note_interro"])) $matiere["note_classe"] = $matiere["note_ds"];
//            $matiere["moy_classe"] = $matiere["note_classe"];


                if(count($matiere->compos)>0){
                    if(count($matiere->compos[0]->notes)>0){
                        if(is_numeric($matiere->compos[0]->notes[0]->note))
                            $matiere["note_compo"] = $matiere->compos[0]->notes[0]->note;
                    }
                }

                else
                    $matiere["note_compo"] = "";

                if(is_numeric($matiere["note_classe"]) && is_numeric($matiere["note_compo"]))
                    $matiere["moy_gen"] = number_format((($matiere["note_classe"]+$matiere["note_compo"])/2),2);
                else
                    $matiere["moy_gen"] = "";

//                echo($matiere["moy_gen"]."->");
                $matiere->coef = (is_numeric($matiere->dispenses[0]->coef))?$matiere->dispenses[0]->coef:$matiere->coef;
                if (is_numeric($matiere["moy_gen"])){
//                    dd($matiere->intitule);
                    array_push($moys,[
                        'eleve_id'=>$eId,
                        'matiere_id'=>$matiere->id,
                        "moy"=>$matiere["moy_gen"]
                    ]);

                    if ($matiere["obligatoire"]==1){
                        array_push($moys_obs,$matiere["moy_gen"]*$matiere->coef);
                    }else{
                        array_push($moys_facs,$matiere["moy_gen"]*$matiere->coef);
                    }
                }
//                $MATIERES[$i]->moys[] = $moys;

            }
//            dd($this->total($eMatieres,"coef"));
            $obligatoires = $this->filter_by_value($eMatieres,"obligatoire",1);
            $facultatives = $this->filter_by_value($eMatieres,"obligatoire",0);

            $coef_obl = $this->total($obligatoires,"coef");
            $coef_fac = $this->total($facultatives,"coef");
            $moy_fac = number_format((array_sum($moys_facs)/$this->total($facultatives,"coef")),2);
            $all_moys = $moys_obs;
            array_push($all_moys,$moy_fac);
            $all_coef = $coef_obl+1;
            $moy_of_eleve = number_format(array_sum($all_moys)/$all_coef,2);
//            dd($moy_of_eleve);

//            $moy_of_eleve = number_format((((array_sum($moys_obs)/$this->total($obligatoires,"coef"))+(array_sum($moys_facs)/$this->total($facultatives,"coef")))/2),2);
            array_push($gen_moys_of_eleves,$moy_of_eleve);
            array_push($moyennes_de_l_eleves_dans_chaque_matiere,$moys);
//            dd($moys);
        }

        if (count($gen_moys_of_eleves)>0)
            $moy_of_classe = number_format(array_sum($gen_moys_of_eleves)/count($gen_moys_of_eleves),2);
        $smallest_moy = $this->getSmallest($gen_moys_of_eleves);
        $biggest_moy = $this->getGreatest($gen_moys_of_eleves);


//        dd($gen_moys_of_eleves);
//        dd($moyennes_de_l_eleves_dans_chaque_matiere);


        foreach ($MATIERES as $MATIERE){
            $MATIERE["moys"] = $this->getMoysInMatieres($moyennes_de_l_eleves_dans_chaque_matiere,$MATIERE->id);
            if (count($MATIERE["moys"])>0)
                $MATIERE["moy_classe"] = number_format((array_sum($MATIERE["moys"]))/count($MATIERE["moys"]),2);
        }

//        dd($MATIERES);

//        $matieres = $matieres::with('interros')->find(4);


        foreach ($MATIERES as $i=>$Mmatiere){
//            dd($Mmatiere->intitule,$Mmatiere->compos);
            $interros_notes=[];
            $ds_notes=[];
            $compos_notes=[];
            // récupération des notes d'interrogations
            $Mmatiere->coef = (is_numeric($Mmatiere->dispenses[0]->coef))?$Mmatiere->dispenses[0]->coef:$Mmatiere->coef;
            foreach ($Mmatiere->interros as $interro){
                if (count($interro->notes)>0){
                    if(is_numeric($interro->notes[0]->note)) $interros_notes[] = $interro->notes[0]->note;
                }
            }
            if(count($interros_notes)>0){
//                dd(array_sum($interros_notes));
                $Mmatiere["note_interro"] = number_format(array_sum($interros_notes)/count($interros_notes),2);
            }else{
                $Mmatiere["note_interro"] = "";
            }

            //récupétration des notes de devoirs sureillés
            foreach ($Mmatiere->ds as $devoir){
                if(count($devoir->notes)>0){if(is_numeric($devoir->notes[0]->note)) $ds_notes[] = $devoir->notes[0]->note;}
            }
            if(count($ds_notes)>0){
                $Mmatiere["note_ds"] = number_format(array_sum($ds_notes)/count($ds_notes),2);
            }else{
                $Mmatiere["note_ds"] = "";
            }

            //calcul moyenne classe
            if(is_numeric($Mmatiere["note_interro"]) && is_numeric($Mmatiere["note_ds"]))
                $Mmatiere["note_classe"] = number_format((($Mmatiere["note_interro"] + $Mmatiere["note_ds"])/2),2);
            elseif (is_numeric($Mmatiere["note_ds"])) $Mmatiere["note_classe"] = $Mmatiere["note_interro"];
            elseif (is_numeric($matiere["note_interro"])) $Mmatiere["note_classe"] = $Mmatiere["note_ds"];
//            $Mmatiere["moy_classe"] = $Mmatiere["note_classe"];


            if(count($Mmatiere->compos)>0){
                if (count($Mmatiere->compos[0]->notes)>0)
                    if(is_numeric($Mmatiere->compos[0]->notes[0]->note)){
                        $Mmatiere["note_compo"] = $Mmatiere->compos[0]->notes[0]->note;
                    }
            }

            else
                $Mmatiere["note_compo"] = "";

            if(is_numeric($matiere["note_classe"]) && is_numeric($Mmatiere["note_compo"])){
                $Mmatiere["moy_gen"] = number_format((($Mmatiere["note_classe"]+$Mmatiere["note_compo"])/2),2);
            }
            else
                $Mmatiere["moy_gen"] = "";

            $Mmatiere["rang"] = $this->getRangInMatiere($Mmatiere->moys,$Mmatiere->moy_gen);
        }

        $moys_tab = $gen_moys_of_eleves;

        $obligatoires = $this->filter_by_value($MATIERES,"obligatoire",1);
        $facultatives = $this->filter_by_value($MATIERES,"obligatoire",0);


        return compact('obligatoires','facultatives','moys_tab',"smallest_moy","biggest_moy","moy_of_classe");
    }

    function filter_by_value ($array, $index, $value){
        $newarray = [];
        foreach ($array as $item){
            if($item[$index]==$value) array_push($newarray,$item);
        }
        return $newarray;
    }

    function getMoysInMatieres($eleves,$id){
        $moys = [];
        foreach ($eleves as $notes){
            foreach ($notes as $note){
//                dd($note["matiere_id"]);
                if ($note["matiere_id"]==$id) array_push($moys,$note['moy']);
            }
        }
        return $moys;
    }

    function getRangInMatiere($moys,$moy){
//        return 0;
        if (is_numeric($moy)){
            $alls = [];
            rsort($moys);
            $key = array_search($moy,$moys);
//        if ($moy == 6.5)
//        dd($moys);
//        dd($key);
            return $key+1;
        }

    }

    function total($array,$key){
        $sum = 0;
        foreach ($array as $item){
            if (is_numeric($item[$key]))
                $sum+=$item[$key];
        }
        return $sum;
    }

    public function getSmallest($array){
        sort($array);
        return $array[0];
    }

    public function getGreatest($array){
        rsort($array);
        return $array[0];
    }

    public function getRang($moys){
        rsort($moys);
    }
}
