<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\XenditCallback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    function callback(Request $request){
        $xendit = new XenditCallback();
        $xendit->callback_id = $request->id;
        $xendit->external_id = $request->external_id;
        $xendit->user_id = $request->user_id;
        $xendit->is_high = $request->is_high;
        $xendit->payment_method = $request->payment_method;
        $xendit->status = $request->status;
        $xendit->merchant_name = $request->merchant_name;
        $xendit->amount = $request->amount;
        $xendit->paid_amount = $request->id;
        $xendit->bank_code = $request->payment_channel;
        $xendit->paid_at = $request->paid_at;
        $xendit->save();

        logger($request->all());
        return response()->json([
            "status" => 1,
            "message" => "Fetched Successfully",
            "data" => $request->all(),
        ], 200);
    }

    function index()
    {
        $transactions = Transaction::select(
            'transaction.id',
            'service_id',
            'provider_id',
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
            ->where('client', auth()->user()->id)
            ->get();

        return response()->json([
            "status" => 1,
            "message" => "Fetched Successfully",
            "data" => $transactions,
        ], 200);
    }

    function sp(){
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
    }
    

    function createTransaction(Request $request)
    {
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
            "data" => $user
        ], 200);
    }
}
