<?php

namespace App\Http\Controllers;

use App\Models\Seance;
use Illuminate\Http\Request;

class gerer_seance extends Controller
{
    /**
     * Display a listing of the resource.
     */
    /**
     * Show the form for creating a new resource.
     */
    public function ajouter_seance(Request $request)
    {
        $validate=$request->validate([
            "day"=>"required",
            "partie_jour"=>"required",
            "order_seance"=>"required",
            "type_seance"=>"required",
            "id_salle"=>"required",
            "id_groupe"=>"required",
            "id_emploi"=>"required",
            "id_formateur"=>"required",
        ]);
        // return response()->json(["message","hi"]);
        $seance=seance::create($validate);
        return back()->with('success', 'Séance créée avec succès');    
    }
    /**
     * Store a newly created resource in storage.
     */
    public function modifier_seance(Request $request)
    {
        $validate=$request->validate([
                "seance_id"=>"required",
                "id_groupe"=>"required",
                "id_salle"=>"required",
                "type_seance"=>"required"
        ]);
        $seance=seance::find($request->seance_id);
        if(!$seance){
          return back()->with('no seance existe');
        }
        if($seance->id_groupe != $request->id_groupe){
            $seance->id_groupe=$request->id_groupe;
        }   
        if($seance->id_salle != $request->id_salle){
            $seance->id_salle = $request->id_salle;
        }  
        if($seance->type_seance != $request->type_seance){
            $seance->type_seance = $request->type_seance;
        }  
        return back()->with("success update!");
    }

    /**
     * Display the specified resource.
     */
    public function show(seance $seance)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(seance $seance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, seance $seance)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(seance $seance)
    {
        //
    }
}
