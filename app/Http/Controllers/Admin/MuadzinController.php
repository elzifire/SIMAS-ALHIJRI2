<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Muadzin;

class MuadzinController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:muadzins.index|muadzins.create|muadzins.edit|muadzins.delete']);
    }
    //
    public function index()
    {
        $muadzins = Muadzin::latest()->when(request()->q, function($muadzins){
            $muadzins = $muadzins->where('name', 'like', '%' . request()->q . '%');
        })->paginate(10);
        return view('admin.muadzin.index', compact('muadzins'));
    }

    public function create()
    {
        return view('admin.muadzin.create');
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'telp' => 'required',
            'image' => 'required',
        ]);

       $image = $request->file('image');
       $image->storeAs('public/muadzin', $image->hashName());

        $muadzin = Muadzin::create([
            'name' => $request->input('name'),
            'telp' => $request->input('telp'),
            'image' => $image->hashName(),
        ]);

        if($muadzin){
            return redirect()->route('admin.muadzin.index')->with(['success' => 'Data Berhasil Disimpan!']);           
        }else {
            return redirect()->route('admin.muadzin.index')->with(['error' => 'Data Gagal Disimpan!']);              
        }
    }

    public function edit(Muadzin $muadzin)
    {
        return view('admin.muadzin.edit', compact('muadzin'));
    }

    public function update(Request $request, Muadzin $muadzin)
{
    $this->validate($request, [
        'name' => 'required',
        'telp' => 'required',
        'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Add image validation
    ]);

    $muadzin = Muadzin::findOrFail($muadzin->id);

    if ($request->hasFile('image')) {
        $image = $request->file('image');
        $image->storeAs('public/muadzin', $image->hashName());
        $muadzin->update(['image' => $image->hashName()]);
    }

    $muadzin->update([
        'name' => $request->input('name'),
        'telp' => $request->input('telp'),
    ]);

    if ($muadzin) {
        //redirect dengan pesan sukses
        return redirect()->route('admin.muadzin.index')->with(['success' => 'Data Berhasil Diupdate!']);
    } else {
        //redirect dengan pesan error
        return redirect()->route('admin.muadzin.edit')->with(['error' => 'Data Gagal Diupdate!']);
    }
}


public function destroy($id)
    {
        $muadzin = Muadzin::findOrFail($id);
        $muadzin->delete();


        if($muadzin){
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
