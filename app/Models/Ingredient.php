<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'image', 'is_allergen'];

    protected $casts = [
        'is_allergen' => 'boolean',
    ];
}
