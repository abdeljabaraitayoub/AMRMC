<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([
    'middleware' => 'api',

], function ($router) {

    Route::post('login', 'App\Http\Controllers\AuthController@login');
    Route::post('register', 'App\Http\Controllers\AuthController@register');
    Route::post('refresh', 'AuthController@refresh');
    Route::get('me', 'App\Http\Controllers\AuthController@me');
});


Route::apiResource('associations', 'App\Http\Controllers\AssociationController');
Route::apiResource('agents', 'App\Http\Controllers\AssociationAgentController');


Route::apiResource('users', 'App\Http\Controllers\UserController');
Route::post('me/image', 'App\Http\Controllers\UserController@image');


Route::apiResource('activities', 'App\Http\Controllers\ActivityLogController');

Route::apiResource('diseases', 'App\Http\Controllers\DiseaseController');
Route::apiResource('patients', 'App\Http\Controllers\PatientController');

Route::apiResource('medics', 'App\Http\Controllers\MedicsController');
Route::apiResource('backup', 'App\Http\Controllers\BackupController');
Route::apiResource('events', 'App\Http\Controllers\EventController');



Route::get('stats/monthly-registrations', 'App\Http\Controllers\StatsController@monthlyRegistrations');
Route::get('stats/patients-disease', 'App\Http\Controllers\StatsController@patients_disease');
Route::get('stats/roles', 'App\Http\Controllers\StatsController@roles');
Route::get('stats', 'App\Http\Controllers\StatsController@counts');
Route::get('stats/associations', 'App\Http\Controllers\StatsController@associations');


//association agents routes
Route::get('association-patients', 'App\Http\Controllers\PatientController@getPatientByAssociation');
Route::get('association-agents', 'App\Http\Controllers\AssociationAgentController@getAgentsByAssociation');
