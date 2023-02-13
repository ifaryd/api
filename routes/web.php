<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;
use App\Http\Services\PredicationService;
use App\Http\Services\PhotoService;
use Illuminate\Http\Request;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect('/fr-fr');
});

Route::get('/fr-fr', function () {
    $request = new Request();
    $request->langue = 1;
    $request->per_page = 4;
    $predicationService = new PredicationService();
    $predications =  $predicationService->filterDataModel($request); 
    return view('templates/index',compact('predications'));
});

Route::get('/fr-fr/predications', function () {
    $request = new Request();
    $request->langue = 1;
    $request->per_page = 10;
    $predicationService = new PredicationService();
    $predications =  $predicationService->filterDataModel($request); 
    return view('templates/predications-lists',compact('predications'));
});

Route::get('/fr-fr/predications/{id}', function ($id) {
    $predicationService = new PredicationService();
    $predication =  $predicationService->findDataModel($id); 
    return view('templates/predications-details',compact('predication'));
});

Route::get('/fr-fr/galeries', function () {
    $request = new Request();
    //$request->langue = 1;
    $request->per_page = 12;
    $photoService = new PhotoService();
    $photos =  $photoService->filterDataModel($request); 
    return view('templates/galeries',compact('photos'));
});