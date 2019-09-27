<?php

namespace App\Http\Controllers;

use App\Personnel;
use Illuminate\Http\Request;

class PersonnelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $personnels = Personnel::get();
        //dd($personnels);
        return view('personnel.personnel' , compact('personnels'));

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
        unset($inputs['personnel_belongstomany_matiere_relationship']);

        if (!$request->ajax()){
            $personnel = Personnel::find($id);
            $personnel->update($inputs);
            $personnel->matieres()->sync($request->personnel_belongstomany_matiere_relationship);
        }

        return redirect('admin/personnels');
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
