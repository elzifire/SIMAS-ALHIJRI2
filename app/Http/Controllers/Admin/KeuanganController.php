<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use app\Models\Keuangan;

class KeuanganController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware(['permission:keuangan.index|keuangan.create|keuangan.edit|keuangan.delete']);

    }

    public function index()
    {
        $keuangans = Keuangan::all();

        return view('admin.keuangan.index', compact('keuangans'));
    }

    public function create()
    {
    return view('admin.keuangan.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'keterangan' => 'required',
            'jumlah' => 'required|numeric',
            'jenis' => 'required|in:masuk,keluar',
            'tanggal' => 'required|date',
        ]);

        Keuangan::create($request->all());

        return redirect()->route('admin.keuangan.index')->with('success', 'Data keuangan berhasil ditambahkan.');
    }

}
