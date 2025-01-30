<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Management;
use Illuminate\Support\Facades\Storage;

class ManagementController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:managements.index|managements.create|managements.delete']);
    }

    public function index()
    {
        $managements = Management::all();
        return view('admin.management.index', compact('managements'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'position' => 'required',
        ]);

        //upload image
        $image = $request->file('image');
        $image->storeAs('public/management', $image->hashName());

        $photo = Management::create([
            'name' => $request->input('name'),
            'position' => $request->input('position'),
            'image' => $image->hashName(),
        ]);

        if ($photo) {
            //redirect dengan pesan sukses
            return redirect()
                ->route('admin.management.index')
                ->with(['success' => 'Data Berhasil Disimpan!']);
        } else {
            //redirect dengan pesan error
            return redirect()
                ->route('admin.management.index')
                ->with(['error' => 'Data Gagal Disimpan!']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $management = Management::findOrFail($id);
        $deleted = Storage::disk('local')->delete('public/management/' . $management->image);
        if (!$deleted) {
            return redirect()->route('admin.management.index')->with(['error' => 'Image Deletion Failed!']);
        }
        $deleteResult = $management->delete();

        if($deleteResult){
            return redirect()->route('admin.management.index')->with(['success' => 'Data Berhasil Dihapus!']);
        }else{
            return redirect()->route('admin.management.index')->with(['error' => 'Data Gagal Dihapus!']);
        }
    }

}
