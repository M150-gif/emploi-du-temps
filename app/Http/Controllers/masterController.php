<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\salle;
use App\Models\groupe;
use App\Models\filiere;
use App\Models\formateur;
use App\Models\emploi;
use App\Models\seance;
use Illuminate\Http\Request;
use App\Http\Requests\forRequests;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Hash;

class masterController extends Controller
{
    public function test(){
        $formateur = formateur::paginate(100000000);
        $dates = emploi::all();
        return view('test',compact('formateur','dates'));
    }
    public function emploi(){
        $dates = emploi::all();
        return view('components.master',compact($dates));
    }
    public function afficher_ajouter_emploi(){
        $emplois= emploi::orderBy('date_debu','desc')->get();
        return view('nouveau_emploi',compact('emplois'));
    }
    public function ajouter_emploi(Request $request){
        $validate=$request->validate([
            "date_debu"=>"required|unique:emplois,date_debu",
            "date_fin"=>"required|unique:emplois,date_fin"
        ]);
        // creer nouveau emploi
        if(empty($request->emploi_temps_ancienne)){
            emploi::create([
                "date_debu"=>$request->date_debu,
                "date_fin"=>$request->date_fin,
            ]);
            return back()->with('emploi created');
            // return redirect(route('home'))->with('success_emploi', 'Emploi créé avec succès.');
        }
        // creer nouveau emploi base sur ancienne
        else{
            $id_emploi=$request->emploi_temps_ancienne;
            $seances=seance::Where('id_emploi',$id_emploi)->get();
            $nouveau_emploi=emploi::create($validate);
            foreach($seances as $seance){
                seance::create([
                    "day"=>$seance->day,
                    "partie_jour"=>$seance->partie_jour,
                    "order_seance"=>$seance->order_seance,
                    "date_debut"=>$seance->date_debut,
                    "date_fin"=>$seance->date_fin,
                    "id_salle"=>$seance->id_salle,
                    "id_formateur"=>$seance->id_formateur,
                    "id_groupe"=>$seance->id_groupe,
                    "id_emploi"=>$nouveau_emploi->id,
                    "type_seance"=>$seance->type_seance,

                ]);
            };
            return response()->json(["message"=>"create emploi and seances successfully"]);
        }
    }
    public function afficher_emploi_par_formateurs(){
        $emplois=emploi::all();
        return view('emplois_formateurs',compact('emplois'));
    }
    public function settingsShow(){
        return view('settings');
    }
    public function showGererFormateur(){
        $formateurs = formateur::paginate(121111111);
        return view('gererFormateur',compact('formateurs'));
    }
    public function showAddFormateur(){
        $formateurs = formateur::paginate(1111111);
        return view('addFormateur',compact('formateurs'));
    }
    public function addFormateur(Request $request){
    // Validate the incoming request data
    $validatedData = $request->validate([
        'name' => 'required|string|max:255', // Adjust validation rules as needed
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
            'name' => 'required|string|max:255', // Adjust validation rules as needed
            // Add more validation rules for other form fields if necessary
        ]);
        $formateur->fill($validatedData)->save();
        return redirect()->route('showGereFormateur');
    }

    public function newFormateur(){
        $formateurs = formateur::paginate(1111111);
        return view('newFormateur',compact('formateurs'));
    }
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
    public function gererUser(){
        return view('gererUser');
    }
    public function updateUser(UserRequest $request,User $user){
        $formFields = $request->validated();
        $formFields['password'] = Hash::make($request->password);
        $user->fill($formFields)->save();
        return to_route('gererUser');
    }
    public function gereFiliere(){
        $filieres = filiere::paginate(11111111);
        return view('gererFiliere',compact('filieres'));
    }
    public function showAddFiliere(){
        $filieres = filiere::paginate(11111111);
        return view('addFiliere',compact('filieres'));
    }
    public function addFiliere(Request $request){
         // Validate the incoming request data
    $validatedData = $request->validate([
        'nom_filier' => 'required|string|max:255', // Adjust validation rules as needed
        // Add more validation rules for other form fields if necessary
    ]);

    // Create a new formateur using the validated data
    filiere::create($validatedData);

    // Redirect to the appropriate route after creating the formateur
    return redirect()->route('gererFiliere');
    }
    public function showUpdateFiliere(filiere $filiere){
        $idFiliere = $filiere->id;
        $filieres = filiere::paginate(11111111);
        return view('showUpdateFiliere',compact('filieres','filiere','idFiliere'));
    }
    public function updateFiliere(Request $request,filiere $filiere){
        $validatedData = $request->validate([
            'nom_filier' => 'required', // Adjust validation rules as needed
            // Add more validation rules for other form fields if necessary
        ]);
        $filiere->fill($validatedData)->save();
        return redirect()->route('gererFiliere');
    }
    public function deleteFiliere(filiere $filiere){
        $filiere->delete();
        return redirect()->route('gererFiliere');
    }
    public function emploi_formateurs(){

    }

}
