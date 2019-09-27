<?php

namespace App\Http\Controllers\Admin;

use App\Classe;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;

class ClasseController extends Controller
{
    public function liste(){
        return view('espaces.admin.classes');
    }

    public function liste_classes(){
        $classes=Classe::with('eleves','niveau','interventions.prof.interventions.matiere','interventions.matiere')->withCount('eleves')->get();
        return $classes;

    }

    public function classes($classe){
        $classes=Classe::with('eleves')->where('nom',$classe)->get();
     /*   $classes=Classe::with('eleves')
            ->where('id',$clas->id)
            ->get();*/
        return $classes;

    }
}
