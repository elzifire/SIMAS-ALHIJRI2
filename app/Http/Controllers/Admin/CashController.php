<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Cash;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class CashController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware(['permission:cash.index|cash.create|cash.edit|cash.delete']);
    }


    public function index(){
        $cashs = Cash::paginate(10); // Menampilkan 10 item per halaman, sesuaikan dengan kebutuhan Anda
        
    return view('admin.cash.index', compact('cashs')); 
    }

    public function create()
{
    // Tampilkan halaman formulir tambah data
    return view('admin.cash.create');
}

public function store(Request $request)
{
    // Validasi data dari formulir
    $request->validate([
        'title' => 'required|string|max:255',
        'cash_flow' => 'required|numeric',
        'date' => 'required|date',
        // Tambahkan aturan validasi lainnya sesuai kebutuhan Anda
    ]);

    // Buat data baru menggunakan model Cash
    Cash::create([
        'title' => $request->input('title'),
        'cash_flow' => $request->input('cash_flow'),
        'date' => $request->input('date'),
        // Tambahkan kolom lain sesuai kebutuhan Anda
    ]);

    // Redirect ke halaman index dengan pesan sukses
    return redirect()->route('admin.cash.index')->with('success', 'Data berhasil ditambahkan');
}


}
