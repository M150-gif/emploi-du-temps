<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\salle;
use App\Models\emploi;
use App\Models\groupe;
use App\Models\seance;
use App\Models\filiere;
use App\Models\formateur;
use Illuminate\Http\Request;
use App\Http\Requests\forRequests;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class masterController extends Controller
{
    public function test(){
        $formateur = formateur::paginate(100000000);
        return view('test',compact('formateur'));
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
        $derniereEmploi = emploi::latest()->first();
        $formateurs=formateur::all();
        $emplois= emploi::orderBy('date_debu','desc')->get();
        $groupes=groupe::all();
        $salles=salle::all();
        $id_emploi=$derniereEmploi->id;
        $seances = seance::where('id_emploi', $id_emploi)->get();
        return view('emplois_formateurs',compact("formateurs",'emplois','id_emploi','seances','groupes','salles'));
    }
    public function afficher_emploi_par_groupes(){
        $derniereEmploi = emploi::latest()->first();
        $formateurs=formateur::all();
        $emplois= emploi::orderBy('date_debu','desc')->get();
        $groupes=groupe::all();
        $salles=salle::all();
        $id_emploi=$derniereEmploi->id;
        $seances = seance::where('id_emploi', $id_emploi)->get();
        return view('emplois_groupes',compact("formateurs",'emplois','id_emploi','seances','groupes','salles'));
    }

    public function showBackUp()
    {
        $latestEmploi = Emploi::latest('date_debu')->first();
        $selectedDate = $latestEmploi ? $latestEmploi->date_debu : null;

        $formateurs = Formateur::all();
        $emplois = Emploi::orderBy('date_debu','desc')->get();
        $groupes = Groupe::all();
        $salles = Salle::all();
        $id_emploi = $latestEmploi ? $latestEmploi->id : null;
        $seances = $latestEmploi ? Seance::where('id_emploi', $latestEmploi->id)->get() : collect();
        $selectedType = 'emploi_formateur'; // Set the default selected type

        // Store the selected date in the session
        session(['selected_date' => $selectedDate]);

        return view('backup', compact("formateurs", 'emplois', 'id_emploi', 'seances', 'groupes', 'salles', 'selectedDate', 'selectedType'));
    }



    public function backup(Request $request)
    {
        // Get the selected date from the request
        $selectedDate = $request->input('selected_date');

        // Store the selected date in the session
        Session::put('selected_date', $selectedDate);

        // Get the selected type from the request
        $selectedType = $request->input('selected_type');

        // Fetch emploi for the selected date
        $emploi = Emploi::where('date_debu', $selectedDate)->first();

        // If no emploi found for the selected date, fetch the latest emploi
        if (!$emploi) {
            $latestEmploi = Emploi::latest('date_debu')->first();

            // Set the default selected date to the latest emploi date
            $selectedDate = $latestEmploi ? $latestEmploi->date_debu : null;
        }

        // Fetch formateurs, groupes, salles
        $formateurs = Formateur::all();
        $groupes = Groupe::all();
        $salles = Salle::all();

        // Fetch seances for the selected emploi
        if ($emploi) {
            $seances = Seance::where('id_emploi', $emploi->id)->get();
            $id_emploi = $emploi->id;
        } else {
            // If no emploi found for the selected date, return an empty collection
            $seances = collect();
            $id_emploi = null;
        }

        // Fetch all emplois (for dropdown)
        $emplois = Emploi::orderBy('date_debu', 'desc')->get();

        // Pass selected date and type to the view
        return view('backup', compact('formateurs', 'emplois', 'id_emploi', 'seances', 'groupes', 'salles', 'selectedDate', 'selectedType'));
    }

    // public function newFormateur(){
    //     $formateurs = formateur::paginate(1111111);
    //     return view('newFormateur',compact('formateurs'));
    // }







    public function filterGroups(Request $request)
    {
        // Validate the request
        $request->validate([
            'school_year' => 'required|string', // Adjust the validation rule based on your expected format
        ]);

        // Retrieve the school year from the request
        $schoolYear = $request->input('school_year');

        // Query the database to retrieve groups based on the provided school year
        $query = Groupe::query()->where('Niveau', $schoolYear);

        // Retrieve the filtered groups
        $filteredGroups = $query->get();

        // Check if any groups are found
        if ($filteredGroups->isEmpty()) {
            // If no groups are found, return an empty array or an appropriate response
            return response()->json([]);
        }

        // Return the filtered groups as JSON response
        return response()->json($filteredGroups);
    }

}
