<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Photo extends Model
{
    use HasFactory;

        /**
     * guarded
     *
     * @var array
     */
    protected $guarded = [];

    protected $primaryKey = 'id';

    /**
     * image
     *
     * @return Attribute
     */
    public function category()
    {
        return $this->belongsTo(CategoriesPhoto::class);
    }

    protected function image(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => asset('/storage/photos/' . $value),
        );
    }
}