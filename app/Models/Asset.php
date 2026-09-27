<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    protected $fillable = [
        'category_id',
        'name',
        'code',
        'total_quantity',
        'good_quantity',
        'damaged_quantity',
        'borrowed_quantity',
        'lost_quantity',
        'is_available',
        'image',
        'description',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
