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
//Login
Route::post('login','App\Http\Controllers\LoginController@login')->name ('user.login')->middleware('guest');

//Film
Route::get('films', 'App\Http\Controllers\FilmController@index')->name('films.index');
Route::get('films/{id}','App\Http\Controllers\FilmController@show')->name('films.show');
Route::get('films/{id}/actors','App\Http\Controllers\FilmController@show')->name('films.showActor');
Route::get('films','App\Http\Controllers\FilmController@search')->name('films.search');

//user
Route::post('user','App\Http\Controllers\UserController@store')->name('user.store');

//protected routes
Route::middleware('auth:sanctum')->group(function(){
    
    Route::middleware('admin')->group(function ()
    {
        //film
        Route::post('films','App\Http\Controllers\FilmController@store')->name('films.store');
        Route::delete('films/{id}','App\Http\Controllers\FilmController@destroy')->name('films.destroy');
    });
    
    //critic
    Route::post('critics','App\Http\Controllers\CriticController@store')->name('critics.store');
    
    //user
    Route::get('user', 'App\Http\Controllers\UserController@show')->name('user.show');
    Route::patch('user','App\Http\Controllers\UserController@edit')->name('user.edit');

    //logout
    Route::post('logout','App\Http\Controllers\LoginController@logout')->name('user.logout');
});

// create tokens
Route::post('/tokens/create', function (Request $request) {
    $token = $request->user()->createToken($request->token_name);
 
    return ['token' => $token->plainTextToken];
});