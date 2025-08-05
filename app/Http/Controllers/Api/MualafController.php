<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pendaftaran;
use Illuminate\Support\Facades\Storage;

class MualafController extends Controller
{
    public function store(Request $request)
    {
        $validated = $this->validate($request, [
            'name' => 'required|string|max:255',
            'nik' => 'required|string|unique:pendaftaran,nik',
            'gender' => 'required|in:Laki-laki,Perempuan',
            'tmptlahir' => 'required|string|max:255',
            'birthdate' => 'required|date',
            'pekerjaan' => 'required|string|max:255',
            'agama' => 'required|in:kristen,hindu,budha,konghucu,yanglainnya',
            'kebangsaan' => 'required|string|max:255',
            'email' => 'required|email|unique:pendaftaran,email',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'alamatktp' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'session_id' => 'nullable|string',
        ]);

        try {
            $mualaf = new Pendaftaran();
            $mualaf->name = $validated['name'];
            $mualaf->nik = $validated['nik'];
            $mualaf->gender = $validated['gender'];
            $mualaf->tmptlahir = $validated['tmptlahir'];
            $mualaf->birthdate = $validated['birthdate'];
            $mualaf->pekerjaan = $validated['pekerjaan'];
            $mualaf->agama = $validated['agama'];
            $mualaf->kebangsaan = $validated['kebangsaan'];
            $mualaf->email = $validated['email'];
            $mualaf->phone = $validated['phone'];
            $mualaf->address = $validated['address'];
            $mualaf->alamatktp = $validated['alamatktp'] ?? null;
            $mualaf->session_id = $validated['session_id'] ?? null;

            if ($request->hasFile('photo')) {
                $photoPath = $request->file('photo')->store('mualaf', 'public');
                $mualaf->photo = $photoPath;
            }

            $mualaf->save();

            return response()->json([
                'message' => 'Data berhasil disimpan',
                'data' => $mualaf,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Data gagal disimpan: ' . $e->getMessage(),
            ], 500);
        }
    }
}