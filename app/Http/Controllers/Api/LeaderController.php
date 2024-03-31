<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Leader;
class LeaderController extends Controller
{
    //
    public function index()
    {
        $leaders = Leader::latest()->paginate(6);
        // variabel = NAMACLASS 
        // LATEST = SELECT * FROM NAMA TABEL ORDER BY ASC WHERE PAGINATION 6 
        return response()->json([
            "response" => [
                "status"    => 200,
                "message"   => "List Data Leader"
            ],
            "data" => $leaders
        ], 200);
    }

    public function LeaderHomePage()
    {
        $leaders = Leader::latest()->take(2)->get();
        return response()->json([
            "response" => [
                "status"    => 200,
                "message"   => "List Data Leader Homepage"
            ],
            "data" => $leaders
        ], 200);
    }
}
