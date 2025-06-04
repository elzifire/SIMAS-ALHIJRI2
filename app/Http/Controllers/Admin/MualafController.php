<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pendaftaran;
use App\Models\Saksi;

class MualafController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:mualafs.index|mualafs.show|mualafs.edit|mualafs.update']);
    }

    public function index()
    {
        $mualafs = Pendaftaran::latest()->when(request()->q, function($query){
            $query->where('nama', 'like', '%'. request()->q . '%');
        })->paginate(5);
        return view('admin.mualaf.index', compact('mualafs'));
    }
    
    public function show($id)
    {
        $mualaf = Pendaftaran::with('saksi')->findOrFail($id);
        return view('admin.mualaf.show', compact('mualaf'));
    }

    public function edit($id)
    {
        $pendaftaran = Pendaftaran::with('saksi')->findOrFail($id);
        
        if (!$pendaftaran->saksi) {
            $pendaftaran->saksi = new Saksi(); 
        }

        return view('admin.mualaf.edit', compact('pendaftaran'));
    }

    public function update(Request $request, $id)
    {
        $pendaftaran = Pendaftaran::with('saksi')->findOrFail($id);

        $validatedData = $request->validate([
            'nama_pembimbing_ikrar' => 'nullable|string|max:255',
            
            'saksi_name2'       => 'required|string|max:255',
            'saksinik2'         => 'required|string|max:255', 
            'gender_saksi2'     => 'required|string|max:255',
            'pekerjaan_saksi2'  => 'required|string|max:255',
            'alamatsaksi2'      => 'required|string',
        ]);

        $pendaftaran->nama_pembimbing_ikrar = $validatedData['nama_pembimbing_ikrar'] ?? null;
        $pendaftaran->save();
        
        $saksiData = [
            'saksi_name2'       => $validatedData['saksi_name2'],
            'saksinik2'         => $validatedData['saksinik2'],
            'gender_saksi2'     => $validatedData['gender_saksi2'],
            'pekerjaan_saksi2'  => $validatedData['pekerjaan_saksi2'],
            'alamatsaksi2'      => $validatedData['alamatsaksi2'],
        ];

        Saksi::updateOrCreate(
            ['pendaftaran_id' => $pendaftaran->id],
            $saksiData 
        );

        return redirect()->route('admin.mualaf.index')->with('success', 'Data pendaftaran mualaf berhasil diperbarui!');
    }
}