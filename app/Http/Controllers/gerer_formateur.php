<?php

namespace App\Http\Controllers;

use App\Models\module;
use App\Models\formateur;
use Illuminate\Http\Request;

class gerer_formateur extends Controller
{
    public function showGererFormateur(){
        $formateurs = formateur::paginate(121111111);
        $modules = module::paginate(111111112);
        return view('gererFormateur',compact('formateurs','modules'));
    }
    public function addFormateur(Request $request){
    // Validate the incoming request data
    $validatedData = $request->validate([
        'name' => 'required|string|max:255', // Adjust validation rules as needed
        'prenom' => 'required|string|max:255',
        // Add more validation rules for other form fields if necessary
    ]);
    // Create a new formateur using the validated data
    formateur::create($validatedData);

    // Redirect to the appropriate route after creating the formateur
    return redirect()->route('showGereFormateur');
    }
    public function deleteFormateur(formateur $formateur){
        $formateur->delete();
        return redirect()->route('showGereFormateur');

    }
    public function showUpdateFormateur(formateur $formateur){
        $idFormateur = $formateur->id;
        $formateurs = formateur::paginate(121111111);
        return view('showUpdateFormateur',compact('formateurs','idFormateur', 'formateur'));
    }
    public function updateFormateur(Request $request,formateur $formateur){
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',// Adjust validation rules as needed
            'prenom' => 'required|string|max:255',
            // Add more validation rules for other form fields if necessary
        ]);
        $formateur->fill($validatedData)->save();
        return redirect()->route('showGereFormateur');
    }

   

}
