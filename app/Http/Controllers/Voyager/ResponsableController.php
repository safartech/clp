<?php

namespace App\Http\Controllers\Voyager;

use App\Personnel;
use Illuminate\Http\Request;
use App\Responsable;
use Illuminate\Support\Facades\DB;
use TCG\Voyager\Http\Controllers\VoyagerBaseController;

class ResponsableController extends VoyagerBaseController
{

    public function store(Request $request)
    {
//        Responsable::create($request->input());
        $inputs = $request->input();
        $inputs['nom_complet'] = $request->nom.' '.$request->prenoms;
        unset($inputs['responsable_belongstomany_elefe_relationship']);
//        dd($inputs);
        if(!$request->ajax()){
            $responsable = Responsable::create($inputs);
            $responsable->eleves()->sync($request->responsable_belongstomany_elefe_relationship);
        }
        return redirect('admin/responsables');
    }


    public function update(Request $request, $id)
    {
//        dd($request->responsable_belongstomany_elefe_relationship);
//        dd($request->input());
        $inputs = $request->input();
        $inputs['nom_complet'] = $request->nom.' '.$request->prenoms;
        unset($inputs['responsable_belongstomany_elefe_relationship']);
//        dd($inputs);
        Responsable::find($id)->update($inputs);
        $resp = Responsable::find($id);
        $resp->eleves()->sync($request->responsable_belongstomany_elefe_relationship);
        return redirect('admin/responsables');
    }

}
