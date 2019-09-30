<?php

namespace App\Http\Controllers;

use App\Information;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class InitController extends Controller
{
    /*get valid informations*/
    public function getValidInformation(){
        $informations=Information::all();
        if($informations !=null){
            $now=strtotime(date('Y-m-d'));
            foreach ($informations as $information){
                if(strtotime($information->start_date)<=$now && $now<=strtotime($information->end_date)){
                    $valid_information=$information;
                    return new JsonResponse($valid_information,200);
                }
        }
    }
}
}
