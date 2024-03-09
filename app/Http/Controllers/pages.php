<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\formateur;
use App\Models\emploi;
use App\Models\seance;
use App\Models\groupe;
use App\Models\salle;
use App\Models\filiere;
class pages extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function home()
    {
     $derniereEmploi = emploi::latest()->first();
      return $this->afficher_emploi_par_id($derniereEmploi->id);
    }
    /**
     * Show the form for creating a new resource.
    */
    public function afficher_formateurs()
    {
        $formateurs=formateur::all();
        return view('formateurs',compact('formateurs'));
    }
    /**
     * Store a newly created resource in storage. nom_filier
     */
    public function groupes()
    {
        $groupes = groupe::with('filiere')->get();
        $filieres=filiere::all();
        return view('groupes',compact('groupes',"filieres"));
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
   
}
