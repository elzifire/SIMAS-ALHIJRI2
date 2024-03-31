<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Enter;
use App\Models\Out;
use Illuminate\Http\Request;

class EnterController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:enters.index|enters.create|enters.edit|enters.delete']);
    }

    public function index()
    {
        $enters = Enter::latest()->paginate(5);
        // Calculate total money in and out
        $moneyIn = Enter::sum('balance');
        $moneyOut = Out::sum('balance');
    
        // Calculate total balance (money in - money out)
        $totalBalance = $moneyIn - $moneyOut;
        return view('admin.enter.index', compact('enters', 'totalBalance', 'moneyIn', 'moneyOut'));
    }

    public function create()
    {
        return view('admin.enter.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'balance' => 'required',
            'date' => 'date',
        ]);

        $total = Enter::sum('balance');

        $enters = Enter::create([
            'name' => $request->input('name'),
            'balance' => $request->input('balance'),
            'date' => $request->input('date'),
            'total' => $total,
        ]);

        if ($enters) {
            return redirect()->route('admin.enter.index')->with(['success' => 'Data Berhasil']);
        }else {
            return redirect()->route('admin.enter.index')->with(['error' => 'gagal']);
        }
    }

    public function edit(Enter $enter)
    {
        return view('admin.enter.edit', compact('enter'));
    }

    public function update(Request $request, Enter $enter)
    {
        $this->validate($request, [
            'name' => 'required',
            'balance' => 'required',
            'date' => 'date',
        ]);
        
        $enter = Enter::findOrFail($enter->id);
        $enter->update([
            'name' => $request->input('name'),
            'balance' => $request->input('balance'),
            'date' => $request->input('date'),
        ]);

        if ($enter) {
            return redirect()->route('admin.enter.index')->with(['success' => 'Data Berhasil']);
        }else {
            return redirect()->route('admin.enter.index')->with(['error' => 'gagal']);
        }

    }
    public function destroy($id)
    {
        $enter = Enter::findOrFail($id);
        $enter->delete();

        if($enter){
            return response()->json([
                'status' => 'success'
            ]);
        }else{
            return response()->json([
                'status' => 'error'
            ]);
        }
    }
}
