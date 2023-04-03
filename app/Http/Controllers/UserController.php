<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class UserController extends Controller
{
    public function store($request)
    {
        # code...
    }
    public function show()
    {
        Auth::check();
        return Auth::user();
    }
}
