<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Category extends Model
{
    use HasTranslations; 
    
    protected $fillable = [
        'image',
        'name'
    ];

    public $translatable = ['name'];

    public function sub_categories()
    {
        return $this->hasMany(SubCategory::class);
    }
}
