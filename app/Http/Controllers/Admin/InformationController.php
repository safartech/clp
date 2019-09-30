<?php

namespace App\Http\Controllers\Admin;

use App\Information;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class InformationController extends Controller
{
    public function index()
    {
        return view('espaces.admin.information');
    }
    public function loadInformations(){
        $informations= Information::get();

 //       if($informations !=null){

        /*desactivate all non valid infos*/
//            $now=strtotime(date('Y-m-d'));
//            foreach ($informations as $info){
//                        if(strtotime($info->start_date)<=$now && $now<=strtotime($info->end_date)){
//                            $info->is_active=0;
//                            $info->save();
//                        }
//                    }
//                }

        return compact("informations");
    }

    public function updateInformations(Request $request,$id){
        $info=Information::find($id);
        $info->update($request->input());
        return 'ok';
    }

    public function store(Request $request)
    {
        $informations=  Information::create( $request->input());
        $info=Information::find($informations->id);
        return $info;

    }
    public function destroy($id)
    {
        Information::destroy($id);
        return 'ok';
    }
    public function activateInformation(Request $request,$id){

        $information=Information::find($id);

        $information->update($request->input());


                /*desactivate other infos*/
//                $infos=Information::all();
//                if($infos!=null){
//                    foreach ($infos as $info){
//                        if($info->id !=$information->id){
//                            $info->is_active=0;
//                            $info->save();
//                        }
//                    }
//                }

                return new JsonResponse(1);
            }
}
