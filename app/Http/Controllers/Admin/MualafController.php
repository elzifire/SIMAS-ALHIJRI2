<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pendaftaran;
use App\Models\Saksi;
use Barryvdh\DomPDF\Facade\Pdf as PDF;

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

    public function downloadSurat($id)
    {
        // Ambil semua data yang diperlukan
        $pendaftaran = Pendaftaran::with('saksi')->findOrFail($id);

        // Nomor Surat (contoh dinamis, sesuaikan formatnya)
        // Format: No / Kode / Nama_Lembaga / Bulan_Romawi / Tahun
        $nomorSurat = sprintf('%03d/SPM/IBNKHALDUNUIKA/%s/%d', 
            $pendaftaran->id, 
            $this->getRomanMonth(date('n')), 
            date('Y')
        );

        // Data yang akan dikirim ke view surat
        $data = [
            'pendaftaran' => $pendaftaran,
            'nomor_surat' => $nomorSurat,
            'nama_ketua_dkm' => 'Dr. H. Dedi Supriadi, M.Si., M.Pd', // Sesuaikan jika ini dinamis
        ];

        // Buat PDF dari view
        $pdf = PDF::loadView('admin.mualaf.surat_pernyataan_pdf', $data);

        // Download PDF dengan nama file dinamis
        return $pdf->download('Surat Pernyataan Mualaf - ' . $pendaftaran->name . '.pdf');
    }

    // Helper function untuk mengubah bulan menjadi angka romawi
    private function getRomanMonth($month) {
        $map = ['M' => 1000, 'CM' => 900, 'D' => 500, 'CD' => 400, 'C' => 100, 'XC' => 90, 'L' => 50, 'XL' => 40, 'X' => 10, 'IX' => 9, 'V' => 5, 'IV' => 4, 'I' => 1];
        $returnValue = '';
        while ($month > 0) {
            foreach ($map as $roman => $int) {
                if($month >= $int) {
                    $month -= $int;
                    $returnValue .= $roman;
                    break;
                }
            }
        }
        return $returnValue;
    }
}