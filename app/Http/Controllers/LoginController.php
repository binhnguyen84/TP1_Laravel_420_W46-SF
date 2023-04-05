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
        // Validate the request data
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Attempt to authenticate the user
        $verify = Auth::attempt(['email' => $request->email, 'password' => $request->password]);
        
        if (!$verify) {
            abort(401, 'courriel ou mots de pass est incorrect');
        }

        $user = User::where('email', $request->email)->first();
        Auth::login($user);

        // Generate an API token for the user using Sanctum
        $token = $user->createToken('api_token')->plainTextToken;

        //Return the user data and token in the response
        return response()->json([
            'user' => New UserResource($user),
            'token' => $token,
        ]);
    }
}
