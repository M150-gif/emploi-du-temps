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
    // public function newFormateur(){
    //     $formateurs = formateur::paginate(1111111);
    //     return view('newFormateur',compact('formateurs'));
    // }







}
