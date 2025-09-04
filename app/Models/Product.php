<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'image',
        'name',
        'price',
        'offer_price',
        'has_offer',
        'best_selling',
        'brand_id',
        'sub_category_id'
    ];

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function sub_category()
    {
        return $this->belongsTo(SubCategory::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    public function exclusive_offer()
    {
        return $this->belongsTo(ExclusiveOffer::class);
    }

    public function best_selling()
    {
        return $this->belongsTo(BestSelling::class);
    }
}
