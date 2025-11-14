<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Campaign extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'campaigns';

    protected $guarded = [];

    // protected $fillable = [
    //     'title',
    //     'slug',
    //     'image',
    //     'goal_amount',
    //     'total_collected',
    //     'description',
    //     'expired',
    //     'category_id',
    //     'bank_info',
    //     'status',
    //     'file_qr',
    // ];

    public function category()
    {
        return $this->belongsTo(CategoriesCampaign::class, 'category_id');
    }

    public function donations()
    {
        return $this->hasMany(Donation::class, 'campaign_id');
    }
}
