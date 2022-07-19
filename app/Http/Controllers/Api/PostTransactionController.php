<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PostTransaction;
use Illuminate\Http\Request;

class PostTransactionController extends Controller
{
    function index(){
        $comments = PostTransaction::get();
        return response()->json([
            "status" => 1,
            "message" => "Fetched Successfully",
            "data" => $comments,
        ], 200);
    }
    function createPostTransaction(Request $request){
        $request->validate([
            'post_id' => 'required',
            'service_provider' => 'required',
            'latitude' => 'required',  
            'longitude' => 'required',
            'status' => 'required',  
        ]);
        $user = new PostTransaction();
        $user->post_id = $request->post_id;
        $user->service_provider = $request->service_provider;
        $user->latitude = $request->latitude;
        $user->longitude = $request->longitude;
        $user->status = $request->status;
        $user->save();
        return response()->json([
            "status" => 1,
            "message" => "Transaction Completed",
            "data"=>$user
        ], 200);
    }
}
