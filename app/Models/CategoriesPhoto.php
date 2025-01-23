<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoriesPhoto extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    public function photos()
    {
        return $this->hasMany(Photo::class);
    }
}
