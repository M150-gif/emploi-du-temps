<?php

namespace App\Http\Controllers;

use App\Models\salle;
use App\Models\emploi;
use App\Models\groupe;
use App\Models\module;
use App\Models\seance;
use App\Models\filiere;
use App\Models\formateur;
use Illuminate\Http\Request;
use App\Models\FormateurModule;

class gerer_emploi extends Controller
{
    /**
     * Display a listing of the resource.
     */
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
            return to_route('emplois_formateurs');
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
            return to_route('emplois_formateurs');
        }
    }
    public function afficher_emploi_par_formateurs(){
        $derniereEmploi = emploi::latest()->first();
        $formateurs=formateur::all();
        $emplois= emploi::orderBy('date_debu','desc')->get();
        $groupes=groupe::all();
        $salles=salle::all();
        $id_emploi="";
        if($derniereEmploi){
            $id_emploi =$derniereEmploi->id;
        }
        $seances = seance::where('id_emploi', $id_emploi)->get();
        $filieres = filiere::all();
        return view('emplois_formateurs',compact("formateurs",'emplois','id_emploi','seances','groupes','salles', 'filieres'));
    }
    public function afficher_emploi_par_groupes(){
        $derniereEmploi = emploi::latest()->first();
        $formateurs=formateur::all();
        $emplois= emploi::orderBy('date_debu','desc')->get();
        $groupes=groupe::all();
        $salles=salle::all();
        $id_emploi="";
        if($derniereEmploi){
            $id_emploi =$derniereEmploi->id;
        }
        $seances = seance::where('id_emploi', $id_emploi)->get();
        return view('emplois_groupes',compact("formateurs",'emplois','id_emploi','seances','groupes','salles'));
    }
    public function afficher_emploi_par_formateur(Request $request){
        $filieres = filiere::all();
        $formateurId = $request->input('formateur_id');
        $derniereEmploi = emploi::latest()->first();
        $id_emploi="";
        if($derniereEmploi){
            $id_emploi =$derniereEmploi->id;
        }
        $groupes = groupe::all();
        $formateurs = formateur::all();
        $salles = salle::all();

        // Get the selected formateur
        $selectedFormateur = null;
        if ($formateurId) {
            $selectedFormateur = formateur::findOrFail($formateurId);
        }

        // Get seances data based on selected formateur
        $seances = [];
        if ($selectedFormateur) {
            $seances = seance::where('id_emploi', $id_emploi)
                ->where('id_formateur', $formateurId)
                ->with('module')
                ->get();
                $modules = FormateurModule::where('formateur_id', $selectedFormateur->id)
                ->where('status', 'oui')
                ->with('module')
                ->get();
        }else{
            $modules = [];
        }
        return view('emploi_formateur', compact("formateurs", 'id_emploi', 'seances', 'groupes', 'salles', 'selectedFormateur','filieres','modules'));
    }
    public function afficher_emploi_par_groupe(Request $request)
{
    $groupeId = $request->input('groupe_id');
    $derniereEmploi = emploi::latest()->first();
    $id_emploi="";
        if($derniereEmploi){
            $id_emploi =$derniereEmploi->id;
        }
    $groupes = groupe::all();
    $formateurs = formateur::all();
    $salles = salle::all();

    // Initialize selected groupe variable
    $selectedGroupe = null;
    if ($groupeId) {
        $selectedGroupe = groupe::findOrFail($groupeId);
    }

    // Retrieve seances data based on selected groupe
    $seances = [];
    if ($selectedGroupe) {
        $seances = seance::where('id_emploi', $id_emploi)
            ->where('id_groupe', $groupeId)
            ->get();
    }

    // Pass the data to the view for rendering
    return view('emploi_groupe', compact('formateurs', 'id_emploi', 'seances', 'groupes', 'salles', 'selectedGroupe'));
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

    public function afficher_emploi_par_filiere(Request $request){
        $filieres = Filiere::all();
        $derniereEmploi = Emploi::latest()->first();
        $formateurs = Formateur::all();
        $emplois = Emploi::orderBy('date_debu','desc')->get();
        $salles = Salle::all();
        $niveaux = Groupe::select('niveau')->distinct()->pluck('niveau');

        // Filter groups based on the selected filiere
        $filiere_id = $request->input('filiere_id');
        $niveau = $request->input('niveau');
        if ($filiere_id && $niveau) {
            $groupes = Groupe::where('filiere_id', $filiere_id)
                             ->where('niveau', $niveau)
                             ->get();
        } elseif ($filiere_id) {
            $groupes = Groupe::where('filiere_id', $filiere_id)
                             ->get();
        } elseif ($niveau) {
            $groupes = Groupe::where('niveau', $niveau)
                             ->get();
        } else {
            $groupes = Groupe::all();
        }

        $id_emploi = $derniereEmploi->id;
        $seances = Seance::where('id_emploi', $id_emploi)->get();

        $selectedFiliereId = $request->input('filiere_id');
        $selectedNiveauId = $request->input('niveau');
        return view('emploi_filiere', compact("formateurs", 'emplois', 'id_emploi', 'seances', 'groupes', 'salles', 'filieres', 'niveaux', 'selectedFiliereId', 'selectedNiveauId'));



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
