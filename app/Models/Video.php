<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Video extends Model
{
    use HasFactory, SoftDeletes;
    
    /**
     * guarded
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * category
     *
     * @return void
     */
    public function category()
    {
        return $this->belongsTo(CategoryVideo::class);
    }
}