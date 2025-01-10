<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mualaf;

class MualafController extends Controller
{
    public function store(Request $request)
    {
       $this->validate($request,[
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
            "foto" => "nullable|image|mimes:jpeg,png,jpg|max:2048",
            "alamat" => "required",
            "alamat_domisili" => "nullable",
        ]);

        $mualaf = Mualaf::create([
            "nama_lengkap" => $request->nama_lengkap,
            "no_ktp" => $request->no_ktp,
            "jenis_kelamin" => $request->jenis_kelamin,
            "tempat_lahir" => $request->tempat_lahir,
            "tanggal_lahir" => $request->tanggal_lahir,
            "pekerjaan" => $request->pekerjaan,
            "agama_sebelumnya" => $request->agama_sebelumnya,
            "kebangsaan" => $request->kebangsaan,
            "email" => $request->email,
            "no_hp" => $request->no_hp,
            "alamat" => $request->alamat,
            "alamat_domisili" => $request->alamat_domisili,
        ]);

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
