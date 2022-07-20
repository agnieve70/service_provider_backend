<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Services;
use App\Models\User;
use Illuminate\Http\Request;

class TotalController extends Controller
{
    //
    public function getTotalNumber(){
        $count_customer = User::where('role', 'customer')->count();
        $count_service_provider = User::where('role', 'service provider')->count();
        $count_services = Services::count();
        return response()->json([
            "status" => 1,
            "message" => "Fetched Successfully",
            "no_customer" => $count_customer,
            "no_service_provider" => $count_service_provider,
            "no_services" => $count_services
        ], 200);
    }

    public function getTotalServiceProvider(){
        $count = User::where('role', 'service provider')->count();
        return response()->json([
            "status" => 1,
            "message" => "Fetched Successfully",
            "data" => $count,
        ], 200);
    }
}
