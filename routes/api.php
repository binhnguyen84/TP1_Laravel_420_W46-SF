<?php
use App\Http\Controllers\FilmController;
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

Route::get('films', 'App\Http\Controllers\FilmController@index')->name('films.index');
Route::get('films/{id}','App\Http\Controllers\FilmController@show')->name('films.show');
Route::get('films/{id}/actors','App\Http\Controllers\FilmController@show')->name('films.showActor');