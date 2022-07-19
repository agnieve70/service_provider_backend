<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ServiceCategory;
use Illuminate\Http\Request;

class ServiceCategoryController extends Controller
{
    function index(){
        $comments = ServiceCategory::get();
        return response()->json([
            "status" => 1,
            "message" => "Fetched Successfully",
            "data" => $comments,
        ], 200);
    }
    function createServiceCategory(Request $request){
        $request->validate([
            'category' => 'required',
        ]);
        $user = new ServiceCategory();
        $user->category = $request->category;
        $user->save();
        return response()->json([
            "status" => 1,
            "message" => "Uploaded",
            "data"=>$user
        ], 200);
}
}