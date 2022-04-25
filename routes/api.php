<?php

use App\Http\Controllers\CountryController;
use App\Http\Controllers\DentistController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::get('/dentists', [DentistController::class, 'index']);
//Route::get('/filter-dentists/name/{name?}/surname/{surname?}/country/{country_id?}/created_at/{created_at?}', [DentistController::class, 'getByFilter']);
Route::get('/filter-dentists', [DentistController::class, 'getByFilter']);

Route::get('/countries', [CountryController::class, 'index']);
