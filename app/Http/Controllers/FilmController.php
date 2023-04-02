<?php

namespace App\Http\Controllers;
use App\Http\Resources\FilmResource;
use App\Models\Film;
use Illuminate\Http\Request;

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

    public function store(Request $request)
    {
        try {
            if (!auth()->user()->tokenCan('modify.films')) {
                abort(403,'Non autorisé');
            }
            $film = Film::create($request->all());
            return (new FilmResource($film))->response();

        } catch (Exception $e) {
            abort(500,'Erreur du serveur');
        }   
    }
    public function destroy($id){
        try {
            if (!auth()->user()->tokenCan('modify.films')) {
                abort(403,'Non autorisé');
            }
            $film = Film::findOrFail($id);
            $film->delete();
        } catch (Exceptions $th) {
            return response()->setStatusCode(500);
        }
        return response()->json(['message'=>'film was deleted'])->setStatusCode(204);
    }
  
}
