<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class UserController extends Controller
{
    function register(Request $request){
        $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users',
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
        $str_rnd = Str::random(5);
            $user->remember_token = $str_rnd;
            $user->password = bcrypt($request->password);
        $user->save();
        if (!$token = auth()->attempt(["email" => $request->email, "password" => $request->password])) {
            return response()->json([
                "errors" => [
                    "user" => 0
                ],
                "message" => "Cannot get token"
            ], 400);
        }

        $token = $request->user()->createToken($request->email);

        return response()->json([
            "status" => 1,
            "message" => "User registered successfully",
            "user_id" => $user->id,
            "token" => $token->plainTextToken,
            "user" => $user
        ], 200);
    }
}
