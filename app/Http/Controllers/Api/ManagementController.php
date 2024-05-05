<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Management;
use Illuminate\Http\Request;

class ManagementController extends Controller
{
    public function index()
    {
        $managements = Management::latest()->get();
        return response()->json([
            "response" => [
                "status"    => 200,
                "message"   => "List Data Pengurus"
            ],
            "data" => $managements
        ], 200);
    }

    public function ManagementHomePage()
    {
        $managements = Management::latest()->take(2)->get();
        return response()->json([
            "response" => [
                "status"    => 200,
                "message"   => "List Data Pengurus Homepage"
            ],
            "data" => $managements
        ], 200);
    }
}
