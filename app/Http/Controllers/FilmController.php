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
            $film = Film::create($request->all());
            return (new FilmResource($film))->response();

        } catch (\Exception $e) {
            abort(500,'Erreur du serveur');
        }   
    }
    public function destroy($id){
        try {
            $film = Film::findOrFail($id);
            $film->delete();
        } catch (Exceptions $th) {
            return response()->setStatusCode(500);
        }
        return response()->json(['message'=>'film was deleted'])->setStatusCode(204);
    }

    public function search(Request $request)
    {
        $keyword = $request->input('keyword');
        $rating = $request->input('rating');
        $max_length = $request->input('max_length');

        $films = Film::query();

        if ($keyword) {
            $films->where('title','LIKE','%'.$keyword.'%')
                    ->orWhere('description','LIKE','%'.$keyword.'%');
        }
        if ($rating) {
            $films->where('rating','LIKE','%'.$rating.'%');
        }
        if ($max_length) {
            $films->where('length','<=','$max_lenth');
        }

        $films = $films->paginate(20);
        if ($films->isEmpty()) {
            abort(404,'Aucun film trouvé');
        }

        return FilmResource::collection($films)->response()->setStatusCode(200);
    }
  
}
