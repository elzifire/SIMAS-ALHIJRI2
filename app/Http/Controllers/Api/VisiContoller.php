<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Visi;

class VisiContoller extends Controller
{
    public function index()
    {
        $visi = Visi::all();
        return response()->json([
            "response" => [
                "status"    => 200,
                "message"   => "List Data Visi"
            ],
            "data" => $visi
        ], 200);
}
}
