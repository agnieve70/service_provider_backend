<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    function index($id){
        $comments = Comment::where('service_id', $id)
        ->join('users', 'users.id', 'comment.user_id')
        ->get();
        
        return response()->json([
            "status" => 1,
            "message" => "Fetched Successfully",
            "data" => $comments,
        ], 200);
    }
    function createComment(Request $request){
        $request->validate([
            'service_id' => 'required',
            'user_id' => 'required',
            'comment' => 'required',   
        ]);
        $user = new Comment();
        $user->service_id = $request->service_id;
        $user->user_id = $request->user_id;
        $user->comment = $request->comment;
        $user->save();
        return response()->json([
            "status" => 1,
            "message" => "Comment Posted",
            "data"=>$user
        ], 200);
    }
}
