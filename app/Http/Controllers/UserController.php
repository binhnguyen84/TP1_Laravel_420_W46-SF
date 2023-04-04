<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Role;
use App\Http\Resources\UserResource;


class UserController extends Controller
{
    public function store(Request $request)
    {
        if (!Auth::guest()) {
            abort(403,'Vous devez vous déconnecter avant de créer un nouveau compte utilisateur');
        }
    
        //verify input data in request
        try {
            
            $validatedData = $request->validate([
                'last_name' => 'required',
                'first_name' => 'required',
                'password' => 'required|min:6',
                'email' => 'required',
                'role_id' => 'required|exists:roles,id',
            ]);
        } catch (\Throwable $th) {
            abort(400,'requête invalide');
        }
        
        $last_name = $validatedData['last_name'];
        $first_name = $validatedData['first_name'];
        $password = $validatedData['password'];
        $email = $validatedData['email'];
        $role_id = $validatedData['role_id'];

        // verify credentials data using Auth::attempt
        if (Auth::attempt(['email' => $email, 'password' => $password])) {
            abort(409,'Le courriel est déjà exsité.');
        }

        //add new user in uers table
        $user = new User();
        $user->password = Hash::make($password);
        $user->last_name = $last_name;
        $user->first_name = $first_name;
        $user->email = $email;
        $user->role_id = $role_id;
        $user->save();

        // return result
        return (new UserResource($user))->response()->setStatusCode(201);
    }

    public function show()
    {
        if (!Auth::check()) {
            abort(401,'Interdit');
        } 
        return Auth::user();  
    }

    public function edit(Request $request)
    {
        if (!Auth::check()) {
            abort(401,'Vous devez vous déconnecter avant de modifier votre compte utilisateur');
        }
        
        //get the authenticated userid
        $id = Auth::id();

        //get the user to be updated
        $userToUpDate = User::findOrFail($id);

        //verify input data in request
        try {
            
            $validatedData = $request->validate([
                'last_name' => 'required',
                'first_name' => 'required',
                'password' => 'required|min:6',
                'role_id' => 'required|exists:roles,id',
                //'new_password'=> 'nullable',
                //'email' => 'required',
            ]);
            
        } catch (\Throwable $th) {
            abort(400,'requête invalide');
        }
        
        //get input data
        $last_name = $validatedData['last_name'];
        $first_name = $validatedData['first_name'];
        $password = $validatedData['password'];
        $role_id = $validatedData['role_id'];

          // verify credentials data using Auth::attempt
        if (!Auth::attempt(['email' => $userToUpDate->email, 'password' => $password])) {
            abort(403,'Non Authorisé');
        }

        $userToUpdate->fill([
            'last_name' => $last_name,
            'first_name'=> $first_name,
            'role_id'=> $role_id
        ]);
        //Revoke user tokens
        $userToUpDate ->tokens()->delete();
        
        //generate new token
        $token = $userToUpDate ->creataToken('authToken')->plainTextToken;
        
        return response()->Json([
            'message' => 'OK',
            'utilisateur' => $userToUpdate,
            'token' => $token
        ]);
    }
}
