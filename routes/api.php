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

//Film
Route::get('films', 'App\Http\Controllers\FilmController@index')->name('films.index')->middleware('auth:sanctum');
Route::get('films/{id}','App\Http\Controllers\FilmController@show')->name('films.show');
Route::get('films/{id}/actors','App\Http\Controllers\FilmController@show')->name('films.showActor');

//protected routes
Route::middleware('auth:sanctum')->group(function(){
    Route::post('films','App\Http\Controllers\FilmController@store')->name('films.store');
    Route::delete('films/{id}','App\Http\Controllers\FilmController@destroy')->name('films.destroy');
});

// create tokens
Route::post('/tokens/create', function (Request $request) {
    $token = $request->user()->createToken($request->token_name);
 
    return ['token' => $token->plainTextToken];
});