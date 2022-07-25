<?php

namespace App\Http\Controllers\Api;

use App\Events\PaymentXendIt;
use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Transaction;
use App\Models\XenditCallback;
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
        
        $transactions = Transaction::select(
            'transaction.id',
            'latitude',
            'longtitude',
            'service',
            'price',
            'transaction.status',
            'transaction.created_at'
        )
            ->join('users', 'users.id', 'transaction.client')
            ->join(
                'services',
                'services.id',
                'transaction.service_id'
            )
            ->whereIn('service_id', 
            function($query) {
                $query->select('id')->from('services')
                ->where('provider_id', auth()->user()->id);
            })
            ->where('provider_id', auth()->user()->id)
            ->get();
        return response()->json([
            "status" => 1,
            "message" => "Fetched Successfully",
            "data" => $transactions,
        ], 200);
        // $comments = XenditCallback::select('category_id', 'service',
        // 'client', 'provider_id',
        // 'longtitude', 'latitude', 'transaction.status')
        // ->join('transaction',
        // 'transaction.transaction_no', 'xendit_callback.external_id')
        // ->join('services', 'services.id', 'transaction.service_id')
        // ->get();
        // return response()->json([
        //     "status" => 1,
        //     "message" => "Fetched Successfully",
        //     "data" => $comments,
        // ], 200);
    }

    function updatePayment(Request $request){
        $request->validate([
            'code' => 'required',
        ]);

        $payment = Transaction::where('transaction_no', $request->code)
        ->where('status','!=' ,'Success')
        ->first();
        if($payment){
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