<?php

namespace App\Http\Controllers\Voyager;

use App\Personnel;
use Illuminate\Http\Request;
use TCG\Voyager\Http\Controllers\VoyagerBaseController;

class PersonnelController extends VoyagerBaseController
{

    public function store(Request $request)
    {
        //
        $inputs = $request->input();
        $inputs['nom_complet'] = $request->nom.' '.$request->prenoms;
        unset($inputs['personnel_belongstomany_matiere_relationship']);

        if (!$request->ajax()){
            $personnel = Personnel::create($inputs);
            $personnel->matieres()->sync($request->personnel_belongstomany_matiere_relationship);

        }

        return redirect('admin/personnels');
    }


    public function update(Request $request, $id)
    {
        $inputs = $request->input();
        $inputs['nom_complet'] = $request->nom.' '.$request->prenoms;
        unset($inputs['personnel_belongstomany_matiere_relationship']);

        if (!$request->ajax()){
            $personnel = Personnel::find($id);
            $personnel->update($inputs);
            $personnel->matieres()->sync($request->personnel_belongstomany_matiere_relationship);
        }

        return redirect('admin/personnels');
    }

}
