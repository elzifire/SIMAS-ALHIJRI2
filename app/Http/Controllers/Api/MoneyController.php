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
        $listMoneyEnter = Enter::latest()->paginate(10);
        $listMoneyOut = Out::latest()->paginate(10);
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
                'list_money_enter' => $listMoneyEnter,
                'list_money_out' => $listMoneyOut
            ]
        ], 200);
    }

    public function grapik()
    {
        $enters = Enter::latest();

        $out = Out::latest();

        $data = [
            'enters' => $enters,
            'out' => $out
        ];

        return response()->json($data, 200);
    }
}

