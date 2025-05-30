<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CategoriesPhoto extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name'
    ];

    public function photos()
    {
        return $this->hasMany(Photo::class);
    }
}
