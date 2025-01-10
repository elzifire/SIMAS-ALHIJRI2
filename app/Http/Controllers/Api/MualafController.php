<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mualaf;

class MualafController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            "nama_lengkap" => "required",
            "no_ktp" => "required",
            "jenis_kelamin" => "required|in:L,P",
            "tempat_lahir" => "required",
            "tanggal_lahir" => "required|date",
            "pekerjaan" => "required",
            "agama_sebelumnya" => "required|in:Islam,Kristen,Katolik,Hindu,Budha,Konghucu,Lainnya",
            "kebangsaan" => "required",
            "email" => "required|email",
            "no_hp" => "required",
            "foto" => "nullable|image",
            "alamat" => "required",
            "alamat_domisili" => "nullable",
        ]);

        $mualaf = Mualaf::create($request->all());

        if ($request->hasFile("foto")) {
            $foto = $request->file("foto")->store("mualaf");
            $mualaf->update(["foto" => $foto]);
        }


        if ($mualaf == true) {
            return response()->json([
                "message" => "Data berhasil disimpan",
                "data" => $mualaf,
            ]);
        } else {
            return response()->json([
                "message" => "Data gagal disimpan",
            ], 500);
        }
    }
}
