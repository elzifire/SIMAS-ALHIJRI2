<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Management extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];


    protected function image(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => asset('/storage/management/' . $value),
        );
    }

}
