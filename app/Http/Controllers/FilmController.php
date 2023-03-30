<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Film;
use App\Http\Resources\FilmCollection;
use App\Http\Resources\FilmResource;

class FilmController extends Controller
{
    public function index()
    {
        try {
            $films = Film::paginate(20);
            return FilmResource::collection($films)->response()->setStatusCode(200);
        } catch (Exception $th) {
            abort(500,'Erreur du serveur');
        }
    }
    public function store($request)
    {
        try {
            $film = Film::create($request->all());
            return (new FilmResource($film))->response()->setStatusCode(201);
        } catch (Exception $e) {
            abort(500,'Erreur du serveur');
        }
    
    }
    public function show($id)
    {
        try {
            $film = Film::findOrFail($id);
            return  (new FilmResource($film))->response()->setStatusCode(200);
        } catch (ModelNotFoundException $e) {
            abort(404,'Film non trouvé');
        }
          catch(Exception $e){
            abort(500,'Erreur du serveur');
        }
    }

    public function avg_rental_rate($language_id)
    {
        $avg_rental_rate = Film::where('language_id', $language_id)->avg('rental_rate');

    return response()->json([
        'average_rental_rate' => $avg_rental_rate
    ])->setStatusCode(200);
    }

}
