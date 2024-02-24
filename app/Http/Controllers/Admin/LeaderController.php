<?php

namespace App\Http\Controllers\Admin;

use App\Models\Leader;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;


class LeaderController extends Controller 
{

    public function __construct()
    {
        $this->middleware(['permission:leaders.index|leaders.create|leaders.edit|leaders.delete']);
    }

    public function index ()
    {
       
        $leaders = Leader::latest()->when(request()->q, function($leaders){
            $leaders = $leaders->where('name', 'like', '%'. request()->q . '%');
        })->paginate(10);
        return view('admin.leader.index', compact('leaders'));
    }


    public function create()
    {
        return view('admin.leader.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'telp' => 'required',
            'image' => 'required',
        ]);

       $image = $request->file('image');
       $image->storeAs('public/leader', $image->hashName());

        $leader = Leader::create([
            'name' => $request->input('name'),
            'telp' => $request->input('telp'),
            'image' => $image->hashName(),
        ]);

        if($leader){
            return redirect()->route('admin.leader.index')->with(['success' => 'Data Berhasil Disimpan!']);           
        }else {
            return redirect()->route('admin.leader.index')->with(['error' => 'Data Gagal Disimpan!']);              
        }
    }


    public function edit()
    {
        return view('admin.leader.edit');
    }
    
    public function update(Request $request, Leader $leader)
    {
        $this->validate($request, [
           'name' => 'required', 
        ]);

        $leader = Leader::findOrFail($leader->id);
         $image = $request->file('image');
       $image->storeAs('public/leader', $image->hashName());

        $leader->update([
            'name' => $request->input('name'),
            'telp' => $request->input('telp'),
            'image' => $image->hashName(),
        ]);

        if($leader){
            //redirect dengan pesan sukses
            return redirect()->route('admin.leader.index')->with(['success' => 'Data Berhasil Diupdate!']);
        }else{
            //redirect dengan pesan error
            return redirect()->route('admin.leader.index')->with(['error' => 'Data Gagal Diupdate!']);
        }

    }

    public function destroy($id)
    {
        $leader = Leader::findOrFail($id);
        $leader->delete();


        if($leader){
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