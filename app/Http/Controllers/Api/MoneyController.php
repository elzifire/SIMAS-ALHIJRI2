<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Money;
use Illuminate\Http\Request;
use Carbon\Carbon;

class MoneyController extends Controller
{
    /**
     * index
     *
     * @return void
     */
    public function MoneyHomePage(Request $request)
    {
        $now = Carbon::now();
        
        // $moneys = Money::latest()
        //     ->whereMonth('created_at', $now->month)
        //     ->whereYear('created_at', $now->year)
        //     ->first();
        // // first for get end record 
        
        $moneys = Money::latest();
        $totalMasuk = Money::where('jenis', 'masuk')->sum('jumlah');
        $totalKeluar = Money::where('jenis', 'keluar')->sum('jumlah');
        $saldo = $totalMasuk - $totalKeluar;
        $moneys = $moneys->paginate(5); // adjust page size to your needs

        return response()->json([
            "response" => [
                "status"  => 200,
                "message" => "Data Keuangan"
            ],
            "data"     => $moneys, $totalMasuk, $totalKeluar
        ], 200);
    }
}
