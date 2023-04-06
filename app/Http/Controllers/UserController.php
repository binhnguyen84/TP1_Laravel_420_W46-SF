<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Role;
use App\Http\Resources\UserResource;
use Illuminate\Routing\Controller;


class UserController extends Controller
{
    public function store(Request $request)
    {
            $request->validate([
                'last_name' => 'required',
                'first_name' => 'required',
                'password' => 'required|min:6',
                'email' => 'required|unique:users,email',
                'role_id' => 'required|exists:roles,id',
            ]);
        
        $user = User::create($request->all());

        //create new token
        if ($user ->role->name == 'admin') {
            $token = $user->createToken('admin',['films:post','films:delete'])->plainTextToken;
            
        }else{

            $token = $user->createToken('member',[''])->plainTextToken;
        }

        // return result
        return response()->Json([
            'message' => 'OK',
            'utilisateur' => $user,
            'token' => $token
        ],201);
    }

    public function show()
    {
        if (!Auth::check()) {
            abort(401,'Interdit');
        } 
        return response(Auth::user(),200);  
    }

    public function edit(Request $request)
    {
       
        $userToUpDate = Auth::user();

        //verify input data in request
        $request->validate([
            'last_name' => 'required',
            'first_name' => 'required',
            'role_id' => 'required|exists:roles,id',
        ]);     
        
        //get input data
        $last_name = $request->input('last_name');
        $first_name = $request->input('first_name');
        $role_id = $request->input('role_id');
        
        $userToUpDate->fill([
            'last_name' => $last_name,
            'first_name'=> $first_name,
            'role_id'=> $role_id
        ]);

        // if request a change of password
        if ($request->has('new_password')) {
            $userToUpDate->password = bcrypt($newPassword);
            $userToUpDate -> save();
        }

        //Revoke user tokens
        $userToUpDate ->tokens()->delete();
        
        if ($userToUpDate ->role->name == 'admin') {
            $token = $userToUpDate->createToken('admin',['films:post','films:delete'])->plainTextToken;
            
        }else{

            $token = $userToUpDate->createToken('member',[''])->plainTextToken;
        }

        // return result
        return response()->Json([
            'message' => 'OK',
            'utilisateur' => $userToUpDate,
            'token' => $token
        ],201);
    }
    public function updatePassword(Request $request)
    {
        $request->validate([
            'oldPassword'=>'required',
            'newPassword'=>'required',
        ]);

        $user = Auth::user();
        $email = $user->email;
        $storedPassword = $user->password;
        $oldPassword = $request -> oldPassword;
        $newPassword = $request -> new_password;

       //authenticate = Auth::attempt(['email' => $email, 'password' => $oldPassword]);
       $authenticate = Hash::check($oldPassword, $storedPassword);
        if (!$authenticate) {
            abort(403,'Non Authorisé');
        }
        $user ->password = Hash::make($newPassword);
        $user -> save();

        return response('Le mot de passe a été modifié avec succès',201);
    }
}
