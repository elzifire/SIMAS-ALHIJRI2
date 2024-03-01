<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Management;

class ManagementController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:managements.index|managements.create|managements.delete']);
    }

    public function index()
    {
        $managements = Management::latest()
            ->when(request()->q, function ($managements) {
                $managements = $managements->where('title', 'like', '%' . request()->q . '%');
            })
            ->paginate(10);

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
}
