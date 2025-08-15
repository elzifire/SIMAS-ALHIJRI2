<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    use HasFactory;

    // tabel status for donation
    protected $table = 'statuses';

    protected $fillable = [
        'name',
    ];

    public function donations()
    {
        return $this->hasMany(Donation::class, 'status_id');
    }
}
