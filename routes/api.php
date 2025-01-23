<?php
use App\Http\Controllers\Api\OptimisationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OptimController_pourtest;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/index', [OptimisationController::class, 'index'])->name('index'); //juste pour les tests
Route::post('/runflask', [OptimisationController::class, 'runFlask'])->name('runflask'); //juste pour les tests
Route::post('/runPlanning', [OptimisationController::class, 'runPlanning'])->name('runPlanning');// ceci est juste pour les tests
Route::get('/runPlanning', [OptimisationController::class, 'runPlanning'])->name('runPlanning');
Route::post('/afficherPlanning', [OptimisationController::class, 'afficherPlanning'])->name('afficherPlanning');
Route::get('/afficherPlanning', [OptimisationController::class, 'afficherPlanning'])->name('afficherPlanning');



Route::post('/savePlanning', [OptimisationController::class, 'savePlanning'])->name('savePlanning');
Route::post('/envoyerPlanning', [OptimisationController::class, 'envoyerPlanning'])->name('envoyerPlanning');
Route::post('/ModifierPlanning', [OptimisationController::class, 'ModifierPlanning'])->name('ModifierPlanning');
Route::post('/updateSoutenance', [OptimisationController::class, 'updateSoutenance'])->name('updateSoutenance');
Route::post('/storeSoutenance', [OptimisationController::class, 'storeSoutenance'])->name('storeSoutenance');
Route::post('/check-jury-availability', [OptimisationController::class, 'checkJuryAvailability'])->name('checkJuryAvailability');
Route::get('/redirect-to-modifier', function (Request $request) {
    return view('planning.Modifierplanning', [
        'session_id' => $request->session_id,
        'type' => $request->type,

    ])->with('success', 'La soutenance a été créée avec succès.');
})->name('redirectToModifier');






Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
