<?php

namespace App\Http\Controllers\Api;

use App\Events\PaymentXendIt;
use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    function makeInvoice(Request $request){
        $request->validate([
            'service_id' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',  
        ]);

        $payment = new PaymentXendIt(auth()->user()->id,
        $request->service_id,
        $request->latitude,
        $request->longitude);
        $result = $payment->setPayment();
        return response()->json([
            "status" => 1,
            "message" => "Invoice Successfully Created",
            "data" => $result,
        ], 200);
    }

    function makePayout(Request $request){
        $request->validate([
            'service_id' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',  
        ]);

        $payment = new PaymentXendIt(auth()->user()->id,
        $request->service_id,
        $request->latitude,
        $request->longitude);

        
        $result = $payment->setPayout();
        return response()->json([
            "status" => 1,
            "message" => "Invoice Successfully Created",
            "data" => $result,
        ], 200);
    }

    function index(){
        $comments = Payment::get();
        return response()->json([
            "status" => 1,
            "message" => "Fetched Successfully",
            "data" => $comments,
        ], 200);
    }
    function createPayment(Request $request){
        $request->validate([
            'invoice_id' => 'required',
            'amount' => 'required',
            'client_id' => 'required',  
            'rating' => 'required',  
        ]);
        $user = new Payment();
        $user->invoice_id = $request->invoice_id;
        $user->amount = $request->amount;
        $user->client_id = $request->client_id;
        $user->rating = $request->rating;
        $user->save();
        return response()->json([
            "status" => 1,
            "message" => "Transaction Completed",
            "data"=>$user
        ], 200);
}
}