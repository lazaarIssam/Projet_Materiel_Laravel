<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use Session;

class MaterialController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $list = DB::table('charlie_materials_filiale1')->paginate(15);
        return view('materiel.index')->with('list', $list);
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
    public function update(Request $request)
    {
        try{
        // On utilise l'id de la ligne pour effectuer la modification
        // Puisqu'on avait deja une base des données et on a pas crée des fichiers Modèl, 
        // c'est plus facile d'utiliser la méthode suivante que d'utiliser la méthode en Commentaire
        $materiel = DB::table('charlie_materials_filiale1')
                    ->where('id',$request->id)
                    ->update(['identification' => $request->identification,'serial_number' => $request->serial_number, 'region' => $request->region]);
        // $materiel = CharlieMaterialsFiliale1Controller::find($request->id);
        // $materiel->identification = $request->identification;
        // $materiel->serial_number = $request->serial_number;
        // $materiel->region = $request->region;
        // $materiel->save();
        Session::flash('success', 'Bien modifier');
        } catch(Throwable $e){
            Session::flash('failed', 'Vous ne pouvez pas modifier ce materiel');
        }
        return redirect()->route('materiel.index');
    }
    
    public function recherche (Request $request){
        if($request->input('recherche') != ""){
        $list = DB::table('charlie_materials_filiale1')
                        ->select('charlie_materials_filiale1.*')
                        ->where('charlie_materials_filiale1.identification','like','%'.$request->input('recherche').'%')
                        ->orWhere('charlie_materials_filiale1.serial_number','like','%'.$request->input('recherche').'%')
                        ->orWhere('charlie_materials_filiale1.region','like','%'.$request->input('recherche').'%')
                        ->distinct()
                        ->paginate(15);
        //return view('materiel.index')->with('list', $list);
        return view('materiel.index',['list' => $list]);
        }else{
            return redirect()->route('materiel.index');
        }
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
        try{
        $materiel = DB::table('charlie_materials_filiale1')
                    ->where('id',$id)
                    ->delete();
        Session::flash('success', 'Bien supprimer');
        } catch(Throwable $e){
            Session::flash('failed', 'Vous ne pouvez pas supprimer ce materiel');
        }
        return redirect()->route('materiel.index');
    }
}
