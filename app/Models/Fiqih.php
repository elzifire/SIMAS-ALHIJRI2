<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fiqih extends Model
{
    use HasFactory;

    protected $connection = "fiqih";

    protected $table = "contents";

    protected $fillable = [
        'id',
        'arabic',
        'indonesia'
    ];

    protected $autoIncrement = false;

    public $timestamps = false;
}
