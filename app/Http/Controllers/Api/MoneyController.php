<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Enter;
use App\Models\Out;
use Illuminate\Support\Facades\Cache;

class MoneyController extends Controller
{
    /**
     * Ambil summary uang masuk, keluar, dan saldo
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function summary(Request $request)
    {
        // Cache hasil sum selama 5 menit biar ga hitung ulang
        $cacheKey = 'money_summary';
        $data = Cache::remember($cacheKey, 300, function () {
            $moneyIn = Enter::whereNull('deleted_at')->sum('balance');
            $moneyOut = Out::whereNull('deleted_at')->sum('balance');
            $saldo = $moneyIn - $moneyOut;

            return [
                'masuk' => $moneyIn,
                'keluar' => $moneyOut,
                'saldo' => $saldo
            ];
        });

        return response()->json([
            'response' => [
                'status' => 200,
                'message' => 'Data Summary Balance'
            ],
            'data' => $data
        ], 200);
    }

    /**
     * Ambil daftar uang masuk dengan paginasi
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function enter(Request $request)
    {
        $query = Enter::whereNull('deleted_at')->latest();

        // Filter berdasarkan date kalo ada
        if ($request->has('date')) {
            $query->whereDate('date', $request->input('date'));
        }

        $listMoneyEnter = $query->paginate(6);

        return response()->json([
            'response' => [
                'status' => 200,
                'message' => 'Daftar Uang Masuk'
            ],
            'data' => $listMoneyEnter
        ], 200);
    }

    /**
     * Ambil daftar uang keluar dengan paginasi
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function out(Request $request)
    {
        $query = Out::whereNull('deleted_at')->latest();

        // Filter berdasarkan date kalo ada
        if ($request->has('date')) {
            $query->whereDate('date', $request->input('date'));
        }

        $listMoneyOut = $query->paginate(6);

        return response()->json([
            'response' => [
                'status' => 200,
                'message' => 'Daftar Uang Keluar'
            ],
            'data' => $listMoneyOut
        ], 200);
    }

    /**
     * Buat web yang udah running, biarin aja
     */
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