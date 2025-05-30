<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Mualaf extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        "nama_lengkap",
        "no_ktp",
        "jenis_kelamin",
        "tempat_lahir",
        "tanggal_lahir",
        "pekerjaan",
        "agama_sebelumnya",
        "kebangsaan",
        "email",
        "no_hp",
        "foto",
        "alamat",
        "alamat_domisili",
    ];

    protected $casts = [
        "tanggal_lahir" => "date",
    ];

    public function getFotoAttribute($value)
    {
        return $value ? asset("storage/{$value}") : null;
    }
}
