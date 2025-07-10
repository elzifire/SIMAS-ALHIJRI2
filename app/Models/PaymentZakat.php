<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;



class PaymentZakat extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected function proof(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => asset('/storage/proof/' . $value),
        );
    }
    
}
