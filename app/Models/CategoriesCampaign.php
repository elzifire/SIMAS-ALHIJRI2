<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CategoriesCampaign extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'categories_campaign';

    protected $fillable = [
        'name',
    ];

    public function campaigns()
    {
        return $this->hasMany(Campaign::class, 'category_id');
    }
}
