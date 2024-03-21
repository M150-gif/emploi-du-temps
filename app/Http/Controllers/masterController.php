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
    public function home(){
        return view('home');
    }


    public function showBackUp()
    {
        $latestEmploi = Emploi::latest('date_debu')->first();
        $selectedDate = $latestEmploi ? $latestEmploi->date_debu : null;
        $filieres = filiere::all();
        $formateurs = Formateur::all();
        $emplois = Emploi::orderBy('date_debu','desc')->get();
        $groupes = Groupe::all();
        $salles = Salle::all();
        $filieres = filiere::all();
        $id_emploi = $latestEmploi ? $latestEmploi->id : null;
        $seances = $latestEmploi ? Seance::where('id_emploi', $latestEmploi->id)->get() : collect();
        $selectedType = 'emploi_formateur'; // Set the default selected type
        $filieres = filiere::all();
        // Store the selected date in the session
        session(['selected_date' => $selectedDate]);

<<<<<<< HEAD
        return view('backup', compact("formateurs", 'emplois', 'id_emploi', 'seances', 'groupes', 'salles', 'selectedDate', 'selectedType','filieres'));
=======
        return view('backup', compact("formateurs", 'emplois', 'id_emploi', 'seances', 'groupes', 'salles', 'selectedDate', 'selectedType', 'filieres'));
>>>>>>> 43c3d593536f6e182cd65ed38ed9ffcd63b8d918
    }



    public function backup(Request $request)
    {

        // Get the selected date from the request
        $selectedDate = $request->input('selected_date');
        $filieres = filiere::all();

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
        $filieres = filiere::all();

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
<<<<<<< HEAD
        return view('backup', compact('formateurs', 'emplois', 'id_emploi', 'seances', 'groupes', 'salles', 'selectedDate', 'selectedType','filieres'));
    }
    public function filterGroups(Request $request)
    {
        $filiere = $request->input('filiere');
        $schoolYear = $request->input('school_year');
        $id_emploi = $request->input('id_emploi');
        $jour = $request->input('jour');
        $seance_order = $request->input('seance_order');

        $query = Groupe::query();

        if ($filiere && $schoolYear) {
            $query->where('filiere_id', $filiere)
                  ->where('Niveau', $schoolYear);
        } elseif ($filiere) {
            $query->where('filiere_id', $filiere);
        } elseif ($schoolYear) {
            $query->where('Niveau', $schoolYear);
=======
        return view('backup', compact('formateurs', 'emplois', 'id_emploi', 'seances', 'groupes', 'salles', 'selectedDate', 'selectedType', 'filieres'));
    }

    // public function filterGroups(Request $request)
    // {
    //     // Retrieve the school year from the request
    //     $schoolYear = $request->input('school_year');

    //     // Query the database to retrieve groups based on the provided school year
    //     $query = Groupe::query()->where('Niveau', $schoolYear);

    //     // Retrieve the filtered groups
    //     $filteredGroups = $query->get();

    //     // Return the filtered groups as JSON response
    //     return response()->json($filteredGroups);
    // }
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
>>>>>>> 43c3d593536f6e182cd65ed38ed9ffcd63b8d918
        }

        // Add additional conditions for checking if groupe is already occupied
        // $query->whereDoesntHave('seance', function($query) use ($id_emploi, $jour, $seance_order) {
        //     $query->where('id_emploi', $id_emploi)
        //           ->where('day', $jour)
        //           ->where('order_seance', $seance_order);
        // });

        $filteredGroups = $query->get();

        return response()->json($filteredGroups);
    }

}
