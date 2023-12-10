<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TotalSaldo extends Model
{
    use HasFactory;
    protected $table = 'total_saldo';

    protected $fillable = ['saldo', 'bulan'];
}
