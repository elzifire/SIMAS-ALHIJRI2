<?php

namespace App\Http\Controllers\Admin;

use App\Models\Money;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class MoneyController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware(['permission:moneys.index|moneys.create|moneys.edit|money.delete']);
    }

    public function index(Request $request)
    {
        $jenis = $request->get('jenis');
        $moneys = Money::orderBy('created_at', 'desc');

        if ($jenis) {
            $moneys = $moneys->where('jenis', $jenis);
        }

        $totalMasuk = Money::where('jenis', 'masuk')->sum('jumlah');
        $totalKeluar = Money::where('jenis', 'keluar')->sum('jumlah');
        $saldo = $totalMasuk - $totalKeluar;
        $moneys = $moneys->paginate(5); // adjust page size to your needs

        return view('admin.money.index', compact('moneys', 'jenis', 'totalMasuk', 'totalKeluar'));
    }

    public function create()
    {
        return view('admin.money.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'jumlah' => 'required|numeric|min:0',
            'jenis' => 'required|in:masuk,keluar',
            'tanggal' => 'required|date',
            'keterangan' => 'required',
        ]);

        // Calculate total masuk and total keluar before the new record
        $totalMasukBefore = Money::where('tanggal', '<', $validatedData['tanggal'])
            ->where('jenis', 'masuk')
            ->sum('jumlah');
        $totalKeluarBefore = Money::where('tanggal', '<', $validatedData['tanggal'])
            ->where('jenis', 'keluar')
            ->sum('jumlah');

        // Calculate saldo for the new record
        $validatedData['saldo'] = $totalMasukBefore - $totalKeluarBefore + $validatedData['jumlah'];

        // Calculate total masuk and total keluar after the new record
        $validatedData['total_masuk'] = $totalMasukBefore + ($validatedData['jenis'] == 'masuk' ? $validatedData['jumlah'] : 0);
        $validatedData['total_keluar'] = $totalKeluarBefore + ($validatedData['jenis'] == 'keluar' ? $validatedData['jumlah'] : 0);

        Money::create($validatedData);

        return redirect()
            ->route('admin.money.index')
            ->with('success', 'Data berhasil ditambahkan');
    }

    public function edit($id)
    {
        $money = Money::findOrFail($id); // Retrieve the money object
        return view('admin.money.edit', compact('money')); // Pass the money object to the view
    }

    public function update(Request $request, $id)
    {
        $money = Money::findOrFail($id); // Find the specific record to update

        $validatedData = $request->validate([
            'jumlah' => 'required|numeric|min:0',
            'jenis' => 'required|in:masuk,keluar',
            'tanggal' => 'required|date',
            'keterangan' => 'required',
        ]);

        // Calculate total masuk and total keluar before the update
        $totalMasukBefore = Money::where('tanggal', '<', $validatedData['tanggal'])
            ->where('jenis', 'masuk')
            ->where('id', '<>', $id) // Exclude the current record
            ->sum('jumlah');
        $totalKeluarBefore = Money::where('tanggal', '<', $validatedData['tanggal'])
            ->where('jenis', 'keluar')
            ->where('id', '<>', $id) // Exclude the current record
            ->sum('jumlah');

        // Calculate saldo for the updated record
        $validatedData['saldo'] = $totalMasukBefore - $totalKeluarBefore + $validatedData['jumlah'];

        // Calculate total masuk and total keluar after the update
        $validatedData['total_masuk'] = $totalMasukBefore + ($validatedData['jenis'] == 'masuk' ? $validatedData['jumlah'] : 0);
        $validatedData['total_keluar'] = $totalKeluarBefore + ($validatedData['jenis'] == 'keluar' ? $validatedData['jumlah'] : 0);

        $money->update($validatedData); // Update the record with the validated data

        return redirect()
            ->route('admin.money.index')
            ->with('success', 'Data berhasil diperbarui');
    }

    public function destroy($id)
    {
        $money = Money::findOrFail($id);
        $money->delete();

        if($money){
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
