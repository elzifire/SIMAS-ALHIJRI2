<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Money;


class DashboardController extends Controller
{    
    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        $moneys = Money::latest();

        return view('admin.dashboard.index', compact('moneys'));
    }


    

}