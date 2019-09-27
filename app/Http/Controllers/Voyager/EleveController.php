<?php

namespace App\Http\Controllers\Voyager;

use App\Eleve;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use TCG\Voyager\Http\Controllers\VoyagerBaseController;

class EleveController extends VoyagerBaseController
{

    protected $storage_path = 'public/eleves/';

    public function getResp(){
        return view('eleves.responsable');
    }

    public function getList(){
        /* $eleves = db::select('select * from eleves');*/
        $eleves = Eleve::with('classe')->get();
//        dd($eleves);
        return view('eleves.liste_eleves', compact('eleves'));
    }

    public function store(Request $request)
    {
        $inputs = $request->input();
        $inputs['nom_complet'] = $request->nom.' '.$request->prenoms;
        unset($inputs['elefe_belongstomany_responsable_relationship']);


        if(!$request->ajax()){
            $eleve =  Eleve::create($inputs);
            $eleve->responsables()->sync($request->elefe_belongstomany_responsable_relationship);
//            dd($request->elefe_belongstomany_responsable_relationship?true:false);
            if ($request->photo){
                $photo = $request->photo[0];
                $eleve->photo = 'eleves/'.$photo->hashName();
                $photo->store($this->storage_path);
                $eleve->save();
            }
        }


        return redirect('admin/eleves');

    }

    public function update(Request $request, $id)
    {
        $inputs = $request->input();
        $inputs['nom_complet'] = $request->nom.' '.$request->prenoms;
        unset($inputs['elefe_belongstomany_responsable_relationship']);

        if(!$request->ajax()){
            Eleve::find($id)->update($inputs);
            $eleve = Eleve::find($id);
            $eleve->responsables()->sync($request->elefe_belongstomany_responsable_relationship);

//            dd($eleve->photo && $request->photo);
            if ($eleve->photo && $request->photo){
                $old_image = $eleve->photo;
//                dd($this->storage_path.$old_image);
                $photo = $request->photo[0];
                $eleve->photo = 'eleves/'.$photo->hashName();
                $photo->store($this->storage_path);
                $eleve->save();
                Storage::delete('public/'.$old_image);
            }
        }


        return redirect('admin/eleves');
    }

}
