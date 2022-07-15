<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    function register(Request $request){
        $request->validate([
            'name' => 'required',
            'email' => 'required|unique:user',
            'password' => 'required',
            'contact' => 'required',
            'firstname' => 'required',
            'lastname' => 'required',
            'role' => 'required',
        ]);
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = $request->password;
        $user->contact = $request->contact;
        $user->firstname = $request->firstname;
        $user->lastname = $request->lastname;
        $user->role = $request->role;
        $user->save();
        return response()->json([
            "status" => 1,
            "message" => "Has been Saved",
            "data"=>$user
        ], 200);
    }
}
