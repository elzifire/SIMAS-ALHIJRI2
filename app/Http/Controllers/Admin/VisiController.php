<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Visi;


class VisiController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:managements.index|managements.create|managements.delete']);
    }

    public function index()
    {
        $visi = Visi::all();
        return view('admin.visi.index', compact('visi'));
    }
    
    public function create()
    {
        return view('admin.visi.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'visi' => 'required',
            'misi' => 'required',
        ]);

        Visi::create($request->all());
        return redirect()->route('admin.visi.index')->with('success', 'Data berhasil ditambahkan');
    }

    public function destroy($id)
    {
        $event = Visi::findOrFail($id);
        $event->delete();

        if($event){
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
