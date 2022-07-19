<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    function index(){
        $comments = Transaction::get();
        return response()->json([
            "status" => 1,
            "message" => "Fetched Successfully",
            "data" => $comments,
        ], 200);
    }
    function createTransaction(Request $request){
        $request->validate([
            'service_id' => 'required',
            'client' => 'required',
            'latitude' => 'required',  
            'longtitude' => 'required',
            'status' => 'required',
        ]);
        $user = new Transaction();
        $user->service_id = $request->service_id;
        $user->client = $request->client;
        $user->latitude = $request->latitude;
        $user->longtitude = $request->longtitude;
        $user->status = $request->status;
        $user->save();
        return response()->json([
            "status" => 1,
            "message" => "Transaction Completed",
            "data"=>$user
        ], 200);
}
}
