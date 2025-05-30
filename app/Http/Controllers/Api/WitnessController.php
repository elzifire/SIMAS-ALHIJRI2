<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Witness;

class WitnessController extends Controller
{
    public function index()
    {
        $witness = Witness::all();
        return response()->json($witness);
    }
}
