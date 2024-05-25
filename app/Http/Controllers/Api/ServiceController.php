<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Service;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::latest();
        
        if ($services->count() == 0){
            return response()->json([
                'message' => 'Service not found',
                'status' => 404,
            ]);
        }else{
            return response()->json([
                'message' => 'Service index',
                'status' => 200,
                'data' => $services->get(),
            ]);
        }
        
       
    }
}
