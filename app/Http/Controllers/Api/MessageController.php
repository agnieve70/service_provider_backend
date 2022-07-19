<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    function index(){
        $comments = Message::get();
        return response()->json([
            "status" => 1,
            "message" => "Fetched Successfully",
            "data" => $comments,
        ], 200);
    }
    function createMessage(Request $request){
        $request->validate([
            'send_by' => 'required',
            'send_to' => 'required',
            'message' => 'required',  
        ]);
        $user = new Message();
        $user->send_by = $request->send_by;
        $user->send_to = $request->send_to;
        $user->message = $request->message;
        $user->save();
        return response()->json([
            "status" => 1,
            "message" => "Comment Posted",
            "data"=>$user
        ], 200);
    }
}
