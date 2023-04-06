<?php

namespace App\Http\Controllers;
use App\Models\Critic;
use App\Models\Film;
use Illuminate\Http\Request;
use App\Http\Resources\CriticResource;
use Illuminate\Support\Facades\Auth;


class CriticController extends Controller
{
    
    public function store(Request $request,$film_id)
    {
            // verify input data
            $request->validate([
                'comment' =>  'required|',
                'score'=>'integer|min:1|max:5',
            ]);
            //get user id
            $user_id = Auth::id();

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
            $critic->comment = $request->comment;
            if ($request->has('score')) {
                $critic->score = $request->score;
            }
            $critic->save();

            //return new critic resource
            return (new CriticResource($critic))->response()->setStatusCode(201);
        
        
    }
}
