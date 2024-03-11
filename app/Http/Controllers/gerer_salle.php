<?php

namespace App\Http\Controllers;

use App\Models\salle;
use Illuminate\Http\Request;

class gerer_salle extends Controller
{
    public function gererSalle(){
        $salles = salle::paginate(1111111);
        return view('gererSalle',compact('salles'));
    }
    public function showAddSalle(){
        $salles = salle::paginate(11111111);
        return view('addSalle',compact('salles'));
    }
    public function addSalle(Request $request){
        $validatedData = $request->validate([
            'nom_salle' => 'required', // Adjust validation rules as needed
            // Add more validation rules for other form fields if necessary
        ]);
        salle::create($validatedData);
        return redirect()->route('showAddSalle');
    }
    public function deleteSalle(salle $salle){
        $salle->delete();
        return redirect()->route('gererSalle');
    }
    public function showUpdateSalle(salle $salle){
        $idSalle = $salle->id;
        $salles = salle::paginate(111111);
        return view('showUpdateSalle',compact('salle','salles','idSalle'));
    }
    public function updateSalle(Request $request,salle $salle){
        $validatedData = $request->validate([
            'nom_salle' => 'required', // Adjust validation rules as needed
            // Add more validation rules for other form fields if necessary
        ]);
        $salle->fill($validatedData)->save();
        return redirect()->route('gererSalle');
    }
}
