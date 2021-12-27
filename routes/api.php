<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DemandeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DemandeurController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\SoutienController;

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
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::apiresource('/demandeurs', DemandeurController::class);
    Route::post('/logout', [AuthController::class, 'logout']);
});
Route::apiresource('/demandeurs', DemandeurController::class);
//Route::apiresource('/etablissements',EtablissementController::class);
//Route::apiresource('/grades',GardeController::class);
Route::apiresource('/demandes',DemandeController::class);

//Route::post('/demandeurs',[DemandeurController::class,'store']);
Route::get('/demande/findByDemandeur/{id}',[DemandeController::class,'findByDemandeur']);
Route::get('/demandes/findByState/{state}',[DemandeController::class,'findByState']);
Route::get('/demandes/findDetails/{id}',[DemandeController::class,'findDetails']);
Route::post('/demandes/validate',[DemandeController::class,'validateDemande']);
Route::post('/demandes/refuse',[DemandeController::class,'refuseDemande']);
Route::post('/soutiens/modifySoutien',[SoutienController::class,'modifySoutien']);
Route::post('/files/uploadFile',[FileController::class,'uploadFile']);
Route::get('/demandes/getLettre/{id}',[DemandeController::class,'getLettre']);



Route::get('/demandeur/findByUser/{id}',[DemandeurController::class,'findByUser']);
