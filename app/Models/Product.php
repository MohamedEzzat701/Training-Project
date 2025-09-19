<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Product extends Model
{
    use HasTranslations;

    protected $fillable = [
        'image',
        'name',
        'price',
        'offer_price',
        // 'has_offer',
        // 'best_selling',
        'brand_id',
        'sub_category_id'
    ];

    public $translatable = ['name', 'description'];

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

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

    public function favoritedBy(User $user)
    {
        return $this->favorites()->where('user_id', $user->id);
    }

    public function exclusive_offer()
    {
        return $this->belongsTo(ExclusiveOffer::class);
    }

    public function best_selling()
    {
        return $this->belongsTo(BestSelling::class);
    }

    public function cartItems()
    {
        return $this->hasMany(Cart::class);
    }
}
