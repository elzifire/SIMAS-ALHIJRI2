<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Money;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * index
     *
     * @return void
     */
    public function index()
    {

       
        return view('admin.dashboard.index');
    }
}
