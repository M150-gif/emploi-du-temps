<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\emploi;

class gerer_emploi extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function ajouter_emploi(Request $request)
    {
        $validate=$request->validate([
            "date_debu"=>"required|unique:emplois,date_debu",
            "date_fin"=>"required|unique:emplois,date_fin"
        ]);
            emploi::create([
                "date_debu" => $validate['date_debu'],
                 "date_fin" => $validate['date_fin']
            ]);
            return response()->json(["message"=>"success"],200);
    }
    public function gererSemaine(){
        $emplois = emploi::paginate(999999);
        return view('gererSemaine',compact('emplois'));
    }


    public function deleteSemaine(Request $request){
        $id = $request->id;
        $emploi = Emploi::findOrFail($id); // Retrieve the emploi instance based on the ID
        $emploi->delete(); // Delete the emploi
        return redirect()->route('gererSemaine'); // Redirect to the desired route
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
