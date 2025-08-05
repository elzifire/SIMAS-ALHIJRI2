<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pendaftaran;

class MualafController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
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

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('mualaf', 'public');
        }

        $mualaf = Pendaftaran::create([
            'name'        => $validated['name'],
            'nik'         => $validated['nik'],
            'gender'      => $validated['gender'],
            'tmptlahir'   => $validated['tmptlahir'],
            'birthdate'   => $validated['birthdate'],
            'pekerjaan'   => $validated['pekerjaan'],
            'agama'       => $validated['agama'],
            'kebangsaan'  => $validated['kebangsaan'],
            'email'       => $validated['email'],
            'phone'       => $validated['phone'],
            'address'     => $validated['address'],
            'alamatktp'   => $validated['alamatktp'] ?? null,
            'session_id'  => $validated['session_id'] ?? null,
            'photo'       => $photoPath,
        ]);

        // Cek apakah gagal disimpan
        if (!$mualaf) {
            return response()->json([
                'message' => 'Data gagal disimpan'
            ], 500);
        }

        // Kalau berhasil
        return response()->json([
            'message' => 'Data berhasil disimpan',
            'data'    => $mualaf,
        ], 201);
    }
}
