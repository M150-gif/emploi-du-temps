<?php

namespace App\Http\Controllers;

use App\Models\formateur;
use Illuminate\Http\Request;


class FormateurController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function ajouter_formateur(Request $request)
    {
        $validate=$request->validate([
            "name"=>"required|unique:formateurs",
            "prenom"=>"required"
        ]);
        $formateur=formateur::create($validate);
        if($formateur){
            return redirect('/formateurs');
        }else{
            
        }

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
    public function show(formateur $formateur)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(formateur $formateur)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, formateur $formateur)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(formateur $formateur)
    {
        //
    }
}
