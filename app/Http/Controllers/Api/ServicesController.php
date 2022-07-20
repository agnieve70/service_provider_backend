<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Services;
use Illuminate\Http\Request;

class ServicesController extends Controller
{
    function index()
    {
        $comments = Services::get();
        return response()->json([
            "status" => 1,
            "message" => "Fetched Successfully",
            "data" => $comments,
        ], 200);
    }

    function getMyService()
    {
        $services = Services::where('provider_id', auth()->user()->id)->get();
        return response()->json([
            "status" => 1,
            "message" => "Fetched Successfully",
            "data" => $services,
        ], 200);
    }

    function createServices(Request $request)
    {
        $request->validate([
            'category_id' => 'required',
            'store' => 'required',
            'service' => 'required',
            'status' => 'required',
            'price' => 'required',
            'description' => 'required',
            'ratings' => 'required',
            'image' => 'required',
        ]);
        $user = new Services();
        $user->category_id = $request->category_id;
        $user->provider_id = auth()->user()->id;
        $user->store = $request->store;
        $user->service = $request->service;
        $user->status = $request->status;
        $user->price = $request->price;
        $user->description = $request->description;
        $user->ratings = $request->ratings;

        $image = $this->uploadPicture($request->file('image'), 'service_images/');
        $user->image = $image;
        $user->save();
        return response()->json([
            "status" => 1,
            "message" => "Uploaded",
            "data" => $user
        ], 200);
    }

    function updateServices(Request $request)
    {
        $request->validate([
            'id' => 'required',
        ]);
        $service = Services::find($request->id);
        
        if($service){

            $service->category_id = !empty($request->category_id) ?  $request->category_id : $service->category_id;
            $service->store = !empty($request->store) ? $request->store : $service->store;
            $service->service = !empty($request->service) ? $request->service : $service->service;
            $service->price = !empty($request->price) ? $request->price : $service->price;
            $service->description = !empty($request->description) ? $request->description : $service->description;
            
            if($request->image === null || $request->image === ""){
                $image = $this->updateFile($service->image, $request->file('image'), 'service_images/');
                $service->image = $image;
            }
            
            $service->save();

            return response()->json([
                "status" => 1,
                "message" => "Updated Service",
                "data" => $service
            ], 200);

        }else{
            return response()->json([
                "status" => 0,
                "message" => "Service not found",
            ], 401);
        }
        
    }

    function deleteService($id){
        $service = Services::find($id);
        
        if($service){
            return response()->json([
                "status" => 1,
                "message" => "Deleted Service",
            ], 200);
        }else{
            return response()->json([
                "status" => 0,
                "message" => "Service not found",
            ], 401);
        }
    }
}
