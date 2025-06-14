<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Muadzin;

class MuadzinController extends Controller
{
    //
    public function index()
    {
        $muadzins = Muadzin::latest();
        return response()->json([
            "response" => [
                "status"    => 200,
                "message"   => "List Data Muadzin"
            ],
            "data" => $muadzins
        ], 200);
    }

    public function MuadzinHomePage()
    {
        $muadzins = Muadzin::latest()->get();
        return response()->json([
            "response" => [
                "status"    => 200,
                "message"   => "List Data Foto Homepage"
            ],
            "data" => $muadzins 
        ], 200);
    }


}
