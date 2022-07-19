<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PostComment;
use Illuminate\Http\Request;

class PostCommentController extends Controller
{
    function index(){
        $comments = PostComment::get();
        return response()->json([
            "status" => 1,
            "message" => "Fetched Successfully",
            "data" => $comments,
        ], 200);
    }
    function createPostComment(Request $request){
        $request->validate([
            'post_id' => 'required',
            'user_id' => 'required',
            'comment' => 'required',   
        ]);
        $user = new PostComment();
        $user->post_id = $request->post_id;
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
