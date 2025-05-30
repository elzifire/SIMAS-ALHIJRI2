<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tag extends Model
{
    use HasFactory, SoftDeletes;
        
    /**
     * guarded
     *
     * @var array
     */
    protected $guarded = [];
    
    /**
     * posts
     *
     * @return void
     */
    public function posts()
    {
        return $this->belongsToMany(Post::class);
    }
}