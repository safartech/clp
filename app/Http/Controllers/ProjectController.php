<?php

namespace App\Http\Controllers;

use App\Absence;
use App\Appreciation;
use App\CahierTexte;
use App\Classe;
use App\ClasseIntrevention;
use App\Cours;
use App\Dispense;
use App\Eleve;
use App\Enseigne;
use App\Examen;
use App\Intervention;
use App\LienParente;
use App\Login;
use App\Matiere;
use App\MatiereGroupe;
use App\MatiereType;
use App\Note;
use App\Personnel;
use App\Responsable;
use App\Salle;
use App\Seance;
use App\Session;
use App\User;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    //
    public function initializeProject(){
//        User::query()->truncate();

        Login::query()->truncate();
        Salle::query()->truncate();
        Classe::query()->truncate();
        Eleve::query()->truncate();
        Responsable::query()->truncate();
        LienParente::query()->truncate();
        Personnel::query()->truncate();

        Matiere::query()->truncate();
        Cours::query()->truncate();
        Examen::query()->truncate();
        Note::query()->truncate();

        Intervention::query()->truncate();
        Dispense::query()->truncate();
        Absence::query()->truncate();
        CahierTexte::query()->truncate();
        Enseigne::query()->truncate();
        ClasseIntrevention::query()->truncate();
        MatiereGroupe::query()->truncate();
        MatiereType::query()->truncate();
        Seance::query()->truncate();
        Appreciation::query()->truncate();

        return "Projet Reinitialisé avec success";
    }
}
