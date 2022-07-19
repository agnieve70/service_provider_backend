<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ServicePost;
use Illuminate\Http\Request;

class ServicePostController extends Controller
{
    function index(){
        $comments = ServicePost::get();
        return response()->json([
            "status" => 1,
            "message" => "Fetched Successfully",
            "data" => $comments,
        ], 200);
    }
    function createServicePost(Request $request){
        $request->validate([
            'title' => 'required',
            'content' => 'required',
            'client_id' => 'required',
            'status' => 'required',
            'price' => 'required',
            'category_id' => 'required',

        ]);
        $user = new ServicePost();
        $user->title = $request->title;
        $user->content = $request->content;
        $user->client_id = $request->client_id;
        $user->status = $request->status;
        $user->price = $request->price;
        $user->category_id = $request->category_id;
        $user->save();
        return response()->json([
            "status" => 1,
            "message" => "Uploaded",
            "data"=>$user
        ], 200);
}
}
