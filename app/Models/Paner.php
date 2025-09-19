<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Paner extends Model
{
    protected $fillable = [
        'image',
        'is_activ',
        'order'
    ];
}
