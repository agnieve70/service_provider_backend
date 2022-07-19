<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class UserController extends Controller
{
    function index(){
        $comments = User::get();
        return response()->json([
            "status" => 1,
            "message" => "Fetched Successfully",
            "data" => $comments,
        ], 200);
    }
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
    function login(Request $request){
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        if (!$token = auth()->attempt(["email" => $request->email, "password" => $request->password])) {
            return response()->json([
                "errors" => [
                    "user" => 0
                ],
                "message" => "Invalid Credentials"
            ], 404);
        }

        $token = $request->user()->createToken($request->email);

        $user = User::where('email', $request->email)->first();

        return response()->json([
            "status" => 1,
            "message" => "Login Successfully",
            "token" => $token->plainTextToken,
            "user" => $user
        ], 200);
    }
}
