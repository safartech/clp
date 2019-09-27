<?php

namespace App\Http\Controllers\Admin;

use App\Classe;
use App\Eleve;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EleveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('espaces.admin.eleves');
    }
    public function loadEleves(){
        $eleves= Eleve::with("classe")->orderBy('nom')->get();
        $classes= Classe::all();
        return compact("eleves","classes");

    }

    public function updateEleves(Request $request,$id){
        $eleve=Eleve::find($id);
        $eleve->update($request->input());
        return 'ok';

    }



    public function test(){
        $classe=Classe::with("eleves")->get();
        $eleve=Eleve::with("classe")->find(16);


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
      $eleve=  Eleve::create( $request->input());
        $eleve=Eleve::with("classe")->find($eleve->id);
        return $eleve;

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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Eleve::destroy($id);
        return 'ok';
    }
}
