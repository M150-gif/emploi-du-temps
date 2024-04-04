<?php

namespace App\Http\Controllers;

use App\Models\groupe;
use App\Models\module;
use App\Models\filiere;
use App\Models\formateur;
use App\Models\GroupeModule;
use Illuminate\Http\Request;
use App\Models\FormateurModule;

class gerer_formateur_module extends Controller
{
    public function gererFormateurModule(){
    // Extract unique niveaux from the groupes

        $filieres = filiere::all();
        $groupes = groupe::all();
        $formateurs = formateur::all();
        $modules = module::all();
        $niveaux = $groupes->pluck('Niveau')->unique();
        return view('gererFormateur_Groupe',compact('modules','formateurs','groupes','filieres','niveaux'));
    }
    public function assignModules(Request $request)
{
    $formateur = Formateur::findOrFail($request->input('formateur_id'));
    $modules = Module::whereIn('id', $request->input('modules'))->get();

    $formateur->modules()->sync($modules);

    return redirect()->back();
}

    public function assignGroupes(Request $request){
        $formateur = Formateur::findOrFail($request->input('formateur_id'));
        $groupes = groupe::whereIn('id', $request->input('groupes'))->get();
        $formateur->groupes()->sync($groupes);
        return redirect()->back();
    }

    public function assignGroupesModules(Request $request)
    {
        $groupes = groupe::findOrFail($request->input('groupeModule'));
        $modules = Module::whereIn('id', $request->input('moduleGroupe'))->get();

        $groupes->modules()->sync($modules);

        return redirect()->back();
    }
public function statusModules(){
    // $FormateurModules = FormateurModule::all();
    $FormateurModules = FormateurModule::with('formateur', 'module')->paginate(999);
    return view('gererStatusModules',compact('FormateurModules'));
}
public function changeStatus(Request $request, $id)
{
    $formateurModule = FormateurModule::findOrFail($id);

    // Toggle the status
    $formateurModule->status = $formateurModule->status === 'oui' ? 'non' : 'oui';
    $formateurModule->save();

    return redirect()->back()->with('success', 'Status updated successfully.');
}

public function getModules($groupeId)
{
    // Fetch modules for the specified groupe ID
    $modules = GroupeModule::where('groupe_id', $groupeId)->with('module')->get();

    return response()->json($modules);
}
public function getAllModules()
{
    $modules = Module::all();
    return response()->json($modules);
}



}
