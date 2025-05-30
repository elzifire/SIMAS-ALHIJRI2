<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Witness;

class WitnessController extends Controller
{
    public function __construct()
    {
         $this->middleware(['permission:mualafs.index|mualafs.show|mualafs.create|mualafs.edit|mualafs.delete']);
    }

    public function index()
    {
        $witnesses = Witness::latest()->when(request()->q, function($witnesses){
            $witnesses = $witnesses->where('name', 'like', '%'. request()->q . '%');
        })->paginate(5);
        return view('admin.witness.index', compact('witnesses'));
    }

    public function create()
    {
        return view('admin.witness.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
        ]);

        $witness = Witness::create([
            'name' => $request->input('name'),
        ]);

        if($witness){
            //redirect dengan pesan sukses
            return redirect()->route('admin.witness.index')->with(['success' => 'Data Berhasil Disimpan!']);
        }else{
            //redirect dengan pesan error
            return redirect()->route('admin.witness.index')->with(['error' => 'Data Gagal Disimpan!']);
        }
    }

    public function edit(Witness $witness)
    {
        return view('admin.witness.edit', compact('witness'));
    }

    public function update(Request $request, Witness $witness)
    {
        $this->validate($request, [
            'name' => 'required',
        ]);
        $witness = Witness::findOrFail($witness->id);
        $witness->update([
            'name' => $request->input('name'),
        ]);
        if($witness){
            //redirect dengan pesan sukses
            return redirect()->route('admin.witness.index')->with(['success' => 'Data Berhasil Diupdate!']);
        }else{
            //redirect dengan pesan error
            return redirect()->route('admin.witness.index')->with(['error' => 'Data Gagal Diupdate!']);
        }
    }
    public function destroy($id)
    {
        $witness = Witness::findOrFail($id);
        $witness->delete();
        if($witness){
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

