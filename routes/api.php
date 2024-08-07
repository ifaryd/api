<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Apis\UserController;
use App\Http\Controllers\Apis\TypeController;
use App\Http\Controllers\Apis\LangueController;
use App\Http\Controllers\Apis\PhotoController;
use App\Http\Controllers\Apis\VideoController;
use App\Http\Controllers\Apis\PaysController;
use App\Http\Controllers\Apis\TemoignageController;
use App\Http\Controllers\Apis\ActualiteController;
use App\Http\Controllers\Apis\VilleController;
use App\Http\Controllers\Apis\ChargeController;
use App\Http\Controllers\Apis\CantiqueController;
use App\Http\Controllers\Apis\PredicationController;
use App\Http\Controllers\Apis\VersetController;
use App\Http\Controllers\Apis\AssembleeController;
use App\Http\Controllers\Apis\ConfirmeController;
use App\Http\Controllers\Apis\ConcordanceController;
use App\Http\Controllers\Apis\MergeDbController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResources([
    'users' => UserController::class,
    'types' => TypeController::class,
    'langues' => LangueController::class,
    'photos' => PhotoController::class,
    'videos' => VideoController::class,
    'pays' => PaysController::class,
    'villes' => VilleController::class,
    'actualites' => ActualiteController::class,
    'temoignages' => TemoignageController::class,
    'charges' => ChargeController::class,
    'cantiques' => CantiqueController::class,
    'predications' => PredicationController::class,
    'versets' => VersetController::class,
    'assemblees' => AssembleeController::class,
    'confirmes' => ConfirmeController::class,
]);

Route::get('/charge_users', [UserController::class, 'charges_user']);
Route::get('/merges', [MergeDbController::class, 'merges']);
Route::post('/concordances', [VersetController::class, 'addConcordance']);
Route::get('/concordances', [ConcordanceController::class, 'index']);
Route::post('/concordances/{predicationId}/{versetId}', [ConcordanceController::class, 'versetConcordance']);
Route::delete('/concordances/{id}', [VersetController::class, 'removeConcordance']);
Route::get('/dirigeant-assemblee/{assemblee_id}', [AssembleeController::class, 'dirigeantAssemblee']);
