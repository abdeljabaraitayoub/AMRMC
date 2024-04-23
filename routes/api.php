<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Middleware\IsLoggedMiddleware;

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


Route::post('login', 'App\Http\Controllers\AuthController@login');
Route::post('register', 'App\Http\Controllers\AuthController@register');
Route::get('refresh', 'App\Http\Controllers\AuthController@refresh');
Route::get('logout', 'App\Http\Controllers\AuthController@logout');
Route::get('me', 'App\Http\Controllers\AuthController@me');
Route::post('generateResetToken', 'App\Http\Controllers\AuthController@generateResetToken');

Route::middleware('role:admin')->group(function () {

    Route::apiResource('associations', 'App\Http\Controllers\AssociationController');
    Route::apiResource('agents', 'App\Http\Controllers\AssociationAgentController');


    Route::apiResource('users', 'App\Http\Controllers\UserController');
    Route::post('me/image', 'App\Http\Controllers\UserController@myimage');
    Route::put('me', 'App\Http\Controllers\UserController@myupdate');
    Route::post('image/{user}', 'App\Http\Controllers\UserController@image');


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
    Route::apiResource('openData', 'App\Http\Controllers\OpenDataController');
    Route::put('openData/{openData}/accept', 'App\Http\Controllers\OpenDataController@accept');


    //association agents routes
    Route::get('association-patients', 'App\Http\Controllers\PatientController@getPatientByAssociation');
    Route::get('association-agents', 'App\Http\Controllers\AssociationAgentController@getAgentsByAssociation');
    Route::put('association/current', 'App\Http\Controllers\AssociationController@updateCurrentAssociation');
    Route::get('association/current', 'App\Http\Controllers\AssociationController@getCurrentAssociation');
    Route::post('association/image', 'App\Http\Controllers\AssociationController@image');
    Route::get('activity/association', 'App\Http\Controllers\ActivityLogController@getactivityperassociation');
    Route::get('stats/association/monthly-registrations', 'App\Http\Controllers\StatsController@monthlyRegistrationsAssociation');
});

Route::get('openData/export/{model}/{format}', 'App\Http\Controllers\OpenDataController@export')->name('openData.export');
