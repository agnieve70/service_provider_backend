<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Services;
use Illuminate\Http\Request;

class ServicesController extends Controller
{
    function index(){
        $comments = Services::get();
        return response()->json([
            "status" => 1,
            "message" => "Fetched Successfully",
            "data" => $comments,
        ], 200);
    }
    function createServices(Request $request){
        $request->validate([
            'category_id' => 'required',
            'provider_id' => 'required',
            'store' => 'required',
            'service' => 'required',
            'status' => 'required',
            'price' => 'required',
            'description' => 'required',
            'ratings' => 'required',
            'image' => 'required',
        ]);
        $user = new Services();
        $user->category_id = $request->category_id;
        $user->provider_id = $request->provider_id;
        $user->store = $request->store;
        $user->service = $request->service;
        $user->status = $request->status;
        $user->price = $request->price;
        $user->description = $request->description;
        $user->ratings = $request->ratings;
        $user->image = $request->image;
        $user->save();
        return response()->json([
            "status" => 1,
            "message" => "Uploaded",
            "data"=>$user
        ], 200);
}
}
