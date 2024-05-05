<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Enter;
use App\Models\Out;

class DashboardController extends Controller
{
    /**
     * index
     *
     * @return void
     */
    public function index()
    {   

        $moneyIn = Enter::sum('balance');
        $moneyOut = Out::sum('balance');
        $saldo = $moneyIn - $moneyOut;
        
        return view('admin.dashboard.index', compact('moneyIn', 'moneyOut', 'saldo'));
    }
}
