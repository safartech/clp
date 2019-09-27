<?php

namespace App\Http\Controllers\Ajax;

use App\Classe;
use App\Eleve;
use App\Retard;
use App\Session;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;

class RetardController extends Controller
{
    //
    public function loadDatas(){
        $classes = Classe::get();
        $sessions = Session::get();
        $eleves = Eleve::with('classe','retards')->get();
        return compact('classes','sessions','eleves');
    }

    public function setEleveAsLate(Request $request){
        if(!$request->isLate){
            Retard::updateOrCreate([
                "eleve_id"=>$request->eleve_id,
                "date"=>$request->date,
            ],
                [
                    "eleve_id"=>$request->eleve_id,
                    "date"=>$request->date,
                    "session_id"=>$request->session_id
                ]);
        }else{
            $retard = Retard::where('date',$request->date)->where('eleve_id',$request->eleve_id)->first();
            Retard::destroy([$retard->id]);
        }



        return Response::HTTP_OK;
    }
}
