<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;
use App\Http\Services\PredicationService;
use App\Http\Services\PhotoService;
use App\Http\Services\VideoService;
use App\Http\Services\UserService;
use App\Http\Services\CantiqueService;
use App\Http\Services\PaysService;
use App\Http\Services\VilleService;
use App\Http\Services\AssembleeService;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\UserController;

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

Route::get('/changeLanguage/{en}', function ($lng) {
    session(['locale'=>$lng]);
    return back();
});

Route::get('/', function () {
    setLocalApplication();
    $request = new Request();
    $langueId = session('langueId');
    $request->langue = 1;
    if($langueId && (int)$langueId >0){
        $request->langue = (int)$langueId;
    }
    $request->per_page = 8;
    $predicationService = new PredicationService();
    $predications =  $predicationService->filterDataModel($request); 
    return view('templates/index',compact('predications'));
});

Route::get('/predications', function () {
    setLocalApplication();
    $request = new Request();
    $langueId = session('langueId');
    $request->langue = 1;
    if($langueId && (int)$langueId >0){
        $request->langue = (int)$langueId;
    }
    $request->per_page = 10;
    $predicationService = new PredicationService();
    $predications =  $predicationService->filterDataModel($request); 
    return view('templates/predications-lists',compact('predications'));
});

Route::get('/predications/{id}', function ($id) {
    setLocalApplication();
    $predicationService = new PredicationService();
    $predication =  $predicationService->findDataModel($id); 
    return view('templates/predications-details',compact('predication'));
});

Route::get('/galeries/photos', function () {
    setLocalApplication();
    $request = new Request();
    $langueId = session('langueId');
    //$request->langue_id = 1;
    if($langueId && (int)$langueId >0){
        //$request->langue_id = (int)$langueId;
    }
    $request->per_page = 12;
    $photoService = new PhotoService();
    $photos =  $photoService->filterDataModel($request); 
    return view('templates/images',compact('photos'));
});

Route::get('/galeries/videos', function () {
    setLocalApplication();
    $request = new Request();
    $langueId = session('langueId');
    //$request->langue_id = 1;
    if($langueId && (int)$langueId >0){
       //$request->langue_id = (int)$langueId;
    }
    $request->per_page = 12;
    $photoService = new VideoService();
    $photos =  $photoService->filterDataModel($request); 
    return view('templates/videos',compact('photos'));
});

Route::get('/changeCantique/{id}', function ($id) {
    setLocalApplication();
    session(['chantre_id'=>$id]);
    return "success";
});

Route::get('/changeAssemblee/{id}', function ($id) {
    setLocalApplication();
    session(['pays_id'=>$id]);
    echo ('success');
});

Route::get('/cantiques', function (Request $request) {
    setLocalApplication();
    $request = new Request();
    $request->langue = 1;
    $request->per_page = 100;
    $cantiqueService = new CantiqueService();
    $userService = new UserService(); 
    $request->charge = "chantre";
    $chantres = $userService->filterDataModel($request);

    if(session('chantre_id') && (int)session('chantre_id')>0){
        $request->user_id = (int)session('chantre_id'); 
    }
    else{
        $request->user_id = (isset($chantres) && isset($chantres[0])) ? $chantres[0]->id :0;
    }
    
    $request->per_page = 15;
    $predications =  $cantiqueService->filterDataModel($request); 
    $userId = $request->user_id;

    return view('templates/louanges',compact('predications', 'chantres', 'userId'));
});

Route::get('/assemblees', function (Request $request) {
    setLocalApplication();
    $request = new Request();
    $request->langue = 1;
    $cantiqueService = new AssembleeService();
    $paysService = new PaysService(); 
    $villeService = new VilleService();

    $chantres = $paysService->filterDataModel($request);

    if(session('pays_id') && (int)session('pays_id')>0){
        $request->pays_id = (int)session('pays_id'); 
    }
    else{
        $request->pays_id = $chantres[0]->id;
    }

    $villes = $villeService->filterDataModel($request);

    $request->per_page = 15;
    $predications =  $cantiqueService->filterDataModel($request); 
    $pays_id = $request->pays_id;

    return view('templates/assemblees',compact('predications', 'chantres', 'pays_id', 'villes'));
});

Route::get('/cantique/{id}', function ($id) {
    setLocalApplication();
    $cantiqueService = new CantiqueService();
    $predication =  $cantiqueService->findDataModel($id); 
    return view('templates/louanges-details',compact('predication'));
});

Route::get('/contacts', function () {
    setLocalApplication();
    return view('templates/contacts');
});

Route::post('/sendEmail', [UserController::class, 'contacts'])->name('contacts');