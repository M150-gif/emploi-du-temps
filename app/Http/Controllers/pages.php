<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\formateur;

class pages extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $formateurs=formateur::all();
        return view('home',compact("formateurs"));
    }
    /**
     * Show the form for creating a new resource.
     * hello changes
     */
    public function afficher_formateurs()
    {
        $formateurs=formateur::all();
        return view('formateurs',compact('formateurs'));
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
