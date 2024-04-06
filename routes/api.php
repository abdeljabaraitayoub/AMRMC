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
Route::apiResource('activities', 'App\Http\Controllers\ActivityLogController');

Route::apiResource('diseases', 'App\Http\Controllers\DiseaseController');
Route::apiResource('patients', 'App\Http\Controllers\PatientController');

Route::apiResource('medics', 'App\Http\Controllers\MedicsController');
Route::apiResource('backup', 'App\Http\Controllers\BackupController');
Route::get('stats/monthly-registrations', 'App\Http\Controllers\StatsController@monthlyRegistrations');
Route::get('stats/patients-disease', 'App\Http\Controllers\StatsController@patients_disease');
