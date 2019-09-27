<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PlanningController extends Controller
{
    //
    public function showClassePage(){ return view('espaces.admin.planning.classes');}
    public function showProfPage(){ return view('espaces.admin.planning.profs');}
    public function showSallePage(){ return view('espaces.admin.planning.salles'); }
}
