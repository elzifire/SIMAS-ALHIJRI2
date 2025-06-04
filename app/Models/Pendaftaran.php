<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Saksi; // PASTIKAN INI ADA untuk mengenali model Saksi

class Pendaftaran extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'pendaftaran';
    protected $guarded = [];

   
    public function saksi()
    {
        return $this->hasOne(Saksi::class, 'pendaftaran_id', 'id');
    }
}