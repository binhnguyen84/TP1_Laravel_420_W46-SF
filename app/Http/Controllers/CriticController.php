<?php

namespace App\Http\Controllers;
use App\Models\Critic;
use Illuminate\Http\Request;
use App\Http\Resources\CriticResource;


class CriticController extends Controller
{
    public function index($id)
    {
        try {
            $critics = Critic::where('film_id',$id)->get();
            return CriticResource::collection($critics)->response()->setStatusCode(200);
        } catch (Exception $e) {
            abort(500,'Erreur du serveur');
        }
    }
}
