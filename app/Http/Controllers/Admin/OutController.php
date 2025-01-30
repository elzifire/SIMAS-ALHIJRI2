<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Out;
use App\Models\Enter;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class OutController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:enters.index|enters.create|enters.edit|enters.delete']);
    }

    public function index()
    {
        // Read data with pagination
        $outs = Out::latest()->paginate(5);
    
        // Calculate total money in and out
        $moneyIn = Enter::sum('balance');
        $moneyOut = Out::sum('balance');
    
        // Calculate total balance (money in - money out)
        $totalBalance = $moneyIn - $moneyOut;
    
        // Pass data to the view
        return view('admin.out.index', compact('outs', 'moneyOut', 'moneyIn', 'totalBalance'));
    }
    
    public function create()
    {
        return view('admin.out.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'balance' => 'required',
            'date' => 'date',
        ]);

        $total = Out::sum('balance');
        
        $outs = Out::create([
            'name' => $request->input('name'),
            'balance' => $request->input('balance'),
            'date' => $request->input('date'),
            'total' => $total,
        ]);

        if ($outs) {
            return redirect()->route('admin.out.index')->with(['success' => 'Data Berhasil']);
        }else {
            return redirect()->route('admin.out.create')->with(['error' => 'gagal']);
        }
    }

    public function edit(Out $out)
    {
        return view('admin.out.edit', compact('out'));
    }

    public function update(Request $request, Out $out)
    {
        $this->validate($request, [
            'name' => 'required',
            'balance' => 'required',
            'date' => 'date',
        ]);
        
        $out = Out::findOrFail($out->id);
        $out->update([
            'name' => $request->input('name'),
            'balance' => $request->input('balance'),
            'date' => $request->input('date'),
        ]);

        if ($out !== null) {
            return redirect()->route('admin.out.index')->with(['success' => 'Data Berhasil']);
        }else {
            return redirect()->route('admin.out.index')->with(['error' => 'gagal']);
        }

    }

    public function destroy($id)
    {
        $out = Out::findOrFail($id);
        $out->delete();

        if ($out !== null) {
            return redirect()->route('admin.out.index')->with(['success' => 'Data Berhasil']);
        }else {
            return redirect()->route('admin.out.index')->with(['error' => 'gagal']);
        }
    }

}
