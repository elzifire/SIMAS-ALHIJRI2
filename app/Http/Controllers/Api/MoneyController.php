<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Money;
use Carbon\Carbon;

class MoneyController extends Controller
{
    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        $now = Carbon::now();
        
        $moneys = Money::latest()
            ->whereMonth('created_at', $now->month)
            ->whereYear('created_at', $now->year)
            ->first();
        // first for get end record 

        return response()->json([
            "response" => [
                "status"  => 200,
                "message" => "Data Keuangan"
            ],
            "data"     => $moneys
        ], 200);
    }
}
