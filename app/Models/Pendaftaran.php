<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;




class Pendaftaran extends Model
{
    use HasFactory;

    protected $table = 'pendaftaran';
    // protected $fillable = ['name', 'nik', 'gender', 'tmptlahir', 'birthdate', 'pekerjaan', 'agama', 'kebangsaan', 'email', 'phone', 'address', 'alamatktp'];

    protected $guarded = [];

    
}

