<?php

namespace App\Http\Controllers;

use App\Models\seance;
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
    // dd($request);
    // Validate the incoming request data
    $validatedData = $request->validate([
        "day" => "required",
        "order_seance" => "required",
        "type_seance" => "required",
        "id_salle" => "required",
        "id_groupe" => "required",
        "id_emploi" => "required",
        "id_formateur" => "required",
        "module_id" => "", // Ensure module_id exists in the modules table
    ]);

    // Create a new Seance instance with the validated data
    $seance = Seance::create($validatedData);

    // Redirect back with success message
    return back();
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
                "type_seance"=>"required",
                "module_id" => "",
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
        if($seance->module_id != $request->module_id){
            $seance->module_id = $request->module_id;
        }
        $seance->save();
        return back()->with("success update!");
    }

    public function modifier_seance_groupe(Request $request)
    {
        $validate=$request->validate([
                "seance_id"=>"required",
                "id_formateur"=>"required",
                "id_salle"=>"required",
                "type_seance"=>"required"
        ]);
        $seance=seance::find($request->seance_id);
        if(!$seance){
          return back()->with('no seance existe');
        }
        if($seance->id_formateur != $request->id_formateur){
            $seance->id_formateur=$request->id_formateur;
        }
        if($seance->id_salle != $request->id_salle){
            $seance->id_salle = $request->id_salle;
        }
        if($seance->type_seance != $request->type_seance){
            $seance->type_seance = $request->type_seance;
        }
        $seance->save();
        return back()->with("success update!");
    }

    /**
     * Display the specified resource.
     */
    public function supprimer_seance(Request $request)
    {
        $validate=$request->validate([
            "seance_id"=>"required"
        ]);
        $seance=seance::find($request->seance_id);
    if(!$seance){
        return back()->with("error", "La séance n'existe pas.");
        }else{
            $seance->delete();
            return back()->with("la seance a supprimer");
        }
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

