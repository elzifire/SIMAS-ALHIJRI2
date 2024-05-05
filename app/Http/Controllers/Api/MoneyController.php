<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Enter;
use App\Models\Out;

class MoneyController extends Controller
{
    /**
     * MoneyHomePage
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function MoneyHomePage(Request $request)
    {
        $moneyIn = Enter::sum('balance');
        $moneyOut = Out::sum('balance');
        $saldo = $moneyIn - $moneyOut;
        
        return response()->json([
            "response" => [
                "status"    => 200,
                "message"   => "Data Balance Information"
            ],
            "data" => [
                'masuk' => $moneyIn,
                'keluar' => $moneyOut,
                'saldo' => $saldo,
            ]
        ], 200);
    }
}

