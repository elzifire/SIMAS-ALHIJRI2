<?php

namespace App\Http\Controllers\Admin;

use App\Models\Money;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;

class MoneyController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware(['permission:moneys.index|moneys.create|moneys.edit|money.delete']);
    }

    public function index(Request $request)
{
    $jenis = $request->get('jenis');
    $moneys = Money::orderBy('created_at', 'desc');

    if ($jenis) {
        $moneys = $moneys->where('jenis', $jenis);
    }

    $moneys = $moneys->paginate(10); // adjust page size to your needs

    return view('admin.money.index', compact('moneys', 'jenis'));
}



    
    public function create()
    {
          return view('admin.money.create'); 
    }


    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'jumlah' => 'required|numeric|min:0',
            'jenis' => 'required|in:masuk,keluar',
            'tanggal' => 'required|date',
        ]);

        $totalSaldo = Money::where('tanggal', '<=', $validatedData['tanggal'])
            ->where('jenis', 'masuk')
            ->sum('jumlah')
            - Money::where('tanggal', '<=', $validatedData['tanggal'])
            ->where('jenis', 'keluar')
            ->sum('jumlah');

        $validatedData['total_saldo'] = $totalSaldo + $validatedData['jumlah'];

        Money::create($validatedData);

        return redirect()->route('admin.money.index')->with('success', 'Data berhasil ditambahkan');
    }
    

}
