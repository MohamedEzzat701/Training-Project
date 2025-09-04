<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BestSelling extends Model
{
    protected $fillable = [
        'product_id',
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
