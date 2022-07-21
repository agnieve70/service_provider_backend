<?php

namespace App\Http\Controllers\Api;

use App\Events\PaymentXendIt;
use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Transaction;
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

    function updatePayment(Request $request){
        $request->validate([
            'code' => 'required',
        ]);

        $payment = Transaction::where('transaction_no', $request->code)->first();
        if($payment){
            $payment->transaction_no = '';
            $payment->status = 'Success';
            $payment->save();
            return response()->json([
                "status" => 1,
                "message" => "Transaction Completed",
                "data"=>$payment
            ], 200);
        }else{
            return response()->json([
                "status" => 0,
                "message" => "Transaction code not found",
            ], 401);
        }
        
    }

    function createPayment(Request $request){
        $request->validate([
            'invoice_id' => 'required',
            'amount' => 'required',
            'client_id' => 'required',  
            'rating' => 'required',  
        ]);
        $payment = new Payment();
        $payment->invoice_id = $request->invoice_id;
        $payment->amount = $request->amount;
        $payment->client_id = $request->client_id;
        $payment->rating = $request->rating;
        $payment->save();
        return response()->json([
            "status" => 1,
            "message" => "Transaction Completed",
            "data"=>$payment
        ], 200);
    }
}