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
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048', // Add image validation
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


    public function edit(Leader $leader)
    {
        return view('admin.leader.edit', compact('leader'));
    }
    
    public function update(Request $request, Leader $leader)
    {
        $this->validate($request, [
            'name' => 'required',
            'telp' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Add image validation
        ]);
    
        $leader = Leader::findOrFail($leader->id);
    
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $image->storeAs('public/leader', $image->hashName());
            $leader->update(['image' => $image->hashName()]);
        }
    
        $leader->update([
            'name' => $request->input('name'),
            'telp' => $request->input('telp'),
        ]);
    
        if ($leader) {
            //redirect dengan pesan sukses
            return redirect()->route('admin.leader.index')->with(['success' => 'Data Berhasil Diupdate!']);
        } else {
            //redirect dengan pesan error
            return redirect()->route('admin.leader.index')->with(['error' => 'Data Gagal Diupdate!']);
        }
    }
    

    // public function destroy($id)
    // {
    //     $leader = Leader::findOrFail($id);
    //     $leader->delete();


    //     if($leader){
    //         return response()->json([
    //             'status' => 'success'
    //         ]);
    //     }else{
    //         return response()->json([
    //             'status' => 'error'
    //         ]);
    //     }
    // }

    public function destroy($id)
    {
        $leader = Leader::findOrFail($id);
        $deleted = Storage::disk('local')->delete('public/leader/' . $leader->image);
        if (!$deleted) {
            return redirect()->route('admin.leader.index')->with(['error' => 'Image Deletion Failed!']);
        }
        $deleteResult = $leader->delete();

        if($deleteResult){
            return redirect()->route('admin.leader.index')->with(['success' => 'Data Berhasil Dihapus!']);
        }else{
            return redirect()->route('admin.leader.index')->with(['error' => 'Data Gagal Dihapus!']);
        }
    }


}