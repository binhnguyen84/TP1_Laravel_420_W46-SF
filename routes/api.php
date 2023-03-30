<?php

use Illuminate\Http\Request;
use App\Http\Controllers\FilmController;
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
Route::get('/films/{id}', [FilmController::class, 'show']);
Route::get('/films', [FilmController::class, 'index']);
Route::get('/films/languages/{id}/avg_rental_rate', [FilmController::class, 'avg_rental_rate']);

Route::post('films','App\Http\Controllers\FilmController@store')->middleware('check.film.year');
//Route::post('/films', [FilmController::class, 'store']);
