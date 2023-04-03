<?php

namespace App\Http\Controllers;
use App\Models\Critic;
use App\Models\Film;
use Illuminate\Http\Request;
use App\Http\Resources\CriticResource;
use Illuminate\Support\Facades\Auth;


class CriticController extends Controller
{
    
    public function store(Request $request)
    {
        //try {
            
            Auth::check();
            // verify input data
            $validatedData = $request->validate([
                'user_id' => 'required|integer',
                'film_id' => 'required|integer',
                'comment' =>  'required|',
            ]);

            // get important data from validated data
            $film_id = $validatedData['film_id'];
            $user_id = $validatedData['user_id'];
            $comment = $validatedData['comment'];
            
            // verify user_id in request must be the same as the id of user sending request
            if ($user_id != Auth::id()) {
                abort(403,'Non authorisé');
            }

            // verify if film exists
            //try {
            //    $film = Film::findOrFail($film_id);
            //} catch (ModelNotFoundException $e) {
            //    abort(404, 'Film non trouvé');
            //}
            
            // Check if a critic for this user and film already exists
            $existingCritic= Critic::select('comment')
                ->where("film_id",$film_id)
                ->where("user_id",$user_id)
                ->first();
            if ($existingCritic) {
                abort(409,'Vous avez écrit une critique sur ce film');
            }

            // create new critic object
            $critic = new Critic;
            $critic->user_id = $user_id;
            $critic->film_id = $film_id;
            $critic->comment = $comment;
            $critic->save();

            //return new critic resource
            return (new CriticResource($critic))->response()->setStatusCode(201);
        //} catch (\Throwable $th) {
        //    abort(500,'Erreur du serveur');
        //}
        
    }
}
