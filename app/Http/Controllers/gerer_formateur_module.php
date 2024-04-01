<?php

namespace App\Http\Controllers;

use App\Models\module;
use App\Models\formateur;
use Illuminate\Http\Request;
use App\Models\FormateurModule;

class gerer_formateur_module extends Controller
{
    public function gererFormateurModule(){
        $formateurs = formateur::all();
        $modules = module::all();
        return view('gererFormateur_Groupe',compact('modules','formateurs'));
    }
    public function assignModules(Request $request)
{
    $formateur = Formateur::findOrFail($request->input('formateur_id'));
    $modules = Module::whereIn('id', $request->input('modules'))->get();

    $formateur->modules()->sync($modules);

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

}
