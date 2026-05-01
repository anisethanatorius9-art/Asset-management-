<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    protected $fillable = [
        'name',
        'serial_number',
        'model',
        'manufacturer',
        'purchase_date',
        'purchase_price',
        'status',
        'category_id',
        'location_id',
    ];
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function location()
    {
        return $this->belongsTo(Location::class);
    }
}
