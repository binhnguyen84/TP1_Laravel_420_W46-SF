<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Laravel\Sanctum\HasApiTokens;
use App\Http\Resources\UserResource;
class LoginController extends Controller
{
    public function login(Request $request)
    {
        if (Auth::check()) {
            return response('Vous étiez déjà connecté',200)->json([
                "user"=>new UserResource($user)
            ]);
        }

        // Validate the request data
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);


        // Attempt to authenticate the user
        $verify = Auth::attempt(['email' => $request->email, 'password' => $request->password]);
        
        if (!$verify) {
            abort(401, 'L\'adresse e-mail ou les mots de passe sont incorrects');
        }

        $user = $request->user();
        
        //delect old login_tokens
        $user->tokens()->where('name','login_token')->delete();

        // Generate an API token for the user using Sanctum 
        $token = $user->createToken('login_token');
        
        //Return the user data and token in the response
        return response()->json([
            'user' => New UserResource($user),
            'token' => $token->plainTextToken,
        ],200);
    }

    public function logout(Request $request)
    {
        $user = $request->user();
        $user->currentAccessToken()->delete();

        return response('Se dèconnecté avec succès.',200);
    }
}
