<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class CategoryVideo extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name'];

    public function videos()
    {
        return $this->hasMany(Video::class);
    }
}
