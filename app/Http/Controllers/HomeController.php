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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return bool
     */
    public function index()
    {
        if(Auth::user()->isAdmin()){
            return view('espaces.admin.home');
        }elseif (Auth::user()->isProf()){
            return view('espaces.prof.home');
        }elseif (Auth::user()->isParent()){
            return view('espaces.parent.home');
        }elseif (Auth::user()->isEleve()){
            return view('espaces.eleve.home');
        }elseif (Auth::user()->isVieScolaire()){
            return view('espaces.protected.retards');
        }
        else{
            return false;
        }
    }

    public function loadProfHome(){
//        $prof = Auth::user()->personnel;
        $prof = Personnel::find(Auth::user()->personnel_id);
        $c = Classe::with('niveau.matieres')->where('personnel_id',$prof->id)->first();
//        $profs = Personnel::with('cours.classe','cours.jour','cours.horaire','cours.matiere','cours.prof','cours.salle','cours.seances')->get();
        $cours = Cours::with(['classe','jour','horaire','prof','matiere','salle','seances'])->where('classe_id',$c->id)->get();
        $jours = Jour::with('cours.classe','cours.matiere','cours.prof','cours.salle','cours.horaire')->get();
        $horaires = Horaire::get();
        $matieres = $c->niveau->matieres??null;
        $classe = Classe::with('cours.classe','cours.jour','cours.horaire','cours.matiere','cours.prof','cours.salle','cours.seances')->where('personnel_id',$prof->id)->first();
        $salles = Salle::get();
        $profs = Personnel::get();

        return compact('classe','jours','horaires','matieres','cours','salles','profs','prof');
    }


    public function loadAdminHome(){}


    public function loadParentHome(){}
}
