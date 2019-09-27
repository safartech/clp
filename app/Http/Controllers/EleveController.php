<?php

namespace App\Http\Controllers;

use App\Eleve;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EleveController extends Controller
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

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
