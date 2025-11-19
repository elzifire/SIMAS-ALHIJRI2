<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Fiqih;

class FiqihController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = Fiqih::query();

        if ($search = request()->q) {
            $keywords = preg_split('/\s+/', $search);

            // Daftar sinonim/fuzzy sederhana
            $fuzzyMap = [
                'salat' => ['salat', 'shalat', 'solat'],
                'zakat' => ['zakat', 'zaca', 'zakatul'],
                // tambahin sesuai kebutuhan
            ];

            foreach ($keywords as $word) {
                $query->where(function($q) use ($word, $fuzzyMap) {
                    // cek apakah ada sinonim
                    $wordsToSearch = $fuzzyMap[strtolower($word)] ?? [$word];

                    foreach ($wordsToSearch as $w) {
                        $q->orWhere('id', 'like', "%{$w}%")
                          ->orWhere('arabic', 'like', "%{$w}%")
                          ->orWhere('indonesia', 'like', "%{$w}%");
                    }
                });
            }
        }

        $data = $query->paginate(10);

        return view('admin.fiqih.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.fiqih.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id' => 'required|unique:fiqih,id', // Id manual, unique
            'arabic' => 'required|string',
            'indonesia' => 'required|string',
        ]);

        Fiqih::create($request->all());

        return redirect()->route('admin.fiqih.index')->with('success', 'Data berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $item = Fiqih::findOrFail($id);
        return view('admin.fiqih.edit', compact('item'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'arabic' => 'required|string',
            'indonesia' => 'required|string',
        ]);

        $item = Fiqih::findOrFail($id);
        $item->update($request->all());

        return redirect()->route('admin.fiqih.index')->with('success', 'Data berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $item = Fiqih::findOrFail($id);
        $item->delete();

        return redirect()->route('admin.fiqih.index')->with('success', 'Data berhasil dihapus!');
    }
}