<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\pages;
use App\Http\Controllers\gerer_emploi;
use App\Http\Controllers\FormateurController;
use App\Http\Controllers\masterController;
use App\Http\Controllers\gerer_seance;
use App\Http\Controllers\gerer_groupe;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|formateursa jouter_groupe modifier_seance
*/
Route::get("/",[pages::class,'home']);
Route::get("/groupes",[pages::class,'groupes'])->name('groupes');
Route::get("/formateurs",[pages::class,'afficher_formateurs']);
Route::post("/ajouter_formateur",[FormateurController::class,'ajouter_formateur'])->name('ajouter_formateur');
Route::post("/ajouter_seance",[gerer_seance::class,'ajouter_seance'])->name('ajouter_seance');
Route::post("/modifier_seance",[gerer_seance::class,'modifier_seance'])->name('modifier_seance');
Route::post("/ajouter_emploi",[gerer_emploi::class,'ajouter_emploi'])->name('ajouter_emploi');
Route::post("/ajouter_groupe",[gerer_groupe::class,'ajouter_groupe'])->name('ajouter_groupe');
// balon door a5oya gheda n9ssedha
Route::get('/test',[masterController::class,'test'])->name('test');

