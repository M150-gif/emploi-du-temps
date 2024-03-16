<?php

use App\Http\Controllers\pages;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\gerer_emploi;
use App\Http\Controllers\authController;
use App\Http\Controllers\masterController;
use App\Http\Controllers\FormateurController;

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
Route::post("/ajouter_emploi",[gerer_emploi::class,'ajouter_emploi'])->name('ajouter_emploi');
Route::post("/ajouter_seance",[gerer_seance::class,'ajouter_seance'])->name('ajouter_seance');
Route::post("/modifier_seance",[gerer_seance::class,'modifier_seance'])->name('modifier_seance');
Route::post("/supprimer_seance",[gerer_seance::class,'supprimer_seance'])->name('supprimer_seance');
Route::get('/afficher-afficher_emploi_par_id/{id_emploi}', [pages::class, 'afficher_emploi_par_id'])->name('afficher_emploi_par_id');
Route::post("/ajouter_groupe",[gerer_groupe::class,'ajouter_groupe'])->name('ajouter_groupe');
Route::post("/afficher_emploi",[pages::class,'afficher_emploi'])->name('afficher_emploi');

// -------------------------------------------
// -------------------------------------------

Route::controller(masterController::class)->group(function(){

    Route::middleware('auth')->group(function(){
        Route::prefix('test')->group(function(){
            Route::get('/','test')->name('test');
            Route::get('/nouveau emploi','afficher_ajouter_emploi')->name('afficher_ajouter_emploi');
            Route::post('/ajouter_emploi','ajouter_emploi')->name('ajouter_emploi');
            Route::get('/emplois_formateurs','afficher_emploi_par_formateurs')->name('emplois_formateurs');
            //groupe fetch
            Route::get('/filter-groups', [masterController::class, 'filterGroups'])->name('filter-groups');
            //groupe fetch
            Route::prefix('/settings')->group(function(){
                Route::get('/','settingsShow')->name('settingsShow');
                Route::prefix('/gererFormateur')->group(function(){
                    Route::get('/','showGererFormateur')->name('showGereFormateur');
                    Route::post('/addFormateur','addFormateur')->name('addFormateur');
                    Route::delete('/{formateur}','deleteFormateur')->name('deleteFormateur');
                    Route::get('/updateFormateur/{formateur}','showUpdateFormateur')->name('showUpdateFormateur');
                    Route::put('/updateFormateur/{formateur}','updateFormateur')->name('updateFormateur');

                });

                Route::prefix('/gererSalle')->group(function(){

                    Route::get('/','gererSalle')->name('gererSalle');
                    Route::get('/addSalle','showAddSalle')->name('showAddSalle');
                    Route::post('/addSalle','addSalle')->name('addSalle');
                    Route::delete('/{salle}','deleteSalle')->name('deleteSalle');
                    Route::get('/updateSalle/{salle}','showUpdateSalle')->name('showUpdateSalle');
                    Route::put('/updateSalle/{salle}','updateSalle')->name('updateSalle');

                });

                Route::prefix('/gererUser')->group(function(){

                    Route::get('/','gererUser')->name('gererUser');
                    Route::put('/{user}','updateUser')->name('updateUser');

                });

                Route::prefix('/gererFiliere')->group(function(){

                    Route::get('/','gereFiliere')->name('gererFiliere');
                    Route::post('/addFiliere','addFiliere')->name('addFiliere');
                    Route::get('/updateFiliere/{filiere}','showUpdateFiliere')->name('showUpdateFiliere');
                    Route::put('/updateFiliere/{filiere}','updateFiliere')->name('updateFiliere');
                    Route::delete('/{filiere}','deleteFiliere')->name('deleteFiliere');

                });

                Route::prefix('/gererGroupe')->group(function(){

                    Route::get('/','gererGroupe')->name('gererGroupe');
                    Route::post('/addGroupe','addGroupe')->name('addGroupe');

                });

                Route::get('/gereSemaine','gererSemaine')->name('gererSemaine');
                Route::post('/gereSemaine','deleteSemaine')->name('deleteSemaine');
            });
        });
    });
});

Route::controller(authController::class)->group(function(){

    Route::middleware('guest')->group(function(){

        Route::get('/login','showLogin')->name('showLogin');
        Route::get('/register','showRegister')->name('showRegister');
        Route::post('/register','createUser')->name('createUser');
        Route::post('/login','login')->name('login');

    });

    Route::middleware('auth')->group(function(){

        Route::get('/logout','logout')->name('logout');

    });
});
// -------------------------------------------
// -------------------------------------------
