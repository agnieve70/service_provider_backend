<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    function index($id){
        $comments = Comment::select('comment.id', 'comment', 'comment.created_at', 'name', 'firstname', 'lastname', 'contact')->where('service_id', $id)
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
            'comment' => 'required',   
        ]);
        $comment = new Comment();
        $comment->service_id = $request->service_id;
        $comment->user_id = auth()->user()->id;
        $comment->comment = $request->comment;
        $comment->save();
        return response()->json([
            "status" => 1,
            "message" => "Comment Posted",
            "data"=>$comment
        ], 200);
    }
}
