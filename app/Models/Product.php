<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'image', 'weight', 'discount', 'price', 'category_id'];

    protected $appends = ['discounted_price'];

    protected $casts = [
        'price' => 'float',
    ];

    public function getDiscountedPriceAttribute(): float
    {
        return round($this->price - ($this->price * $this->discount / 100), 2);
    }

    public function ingredients(): BelongsToMany
    {
        return $this->belongsToMany(Ingredient::class)->withTimestamps();
    }

    public function category(): BelongsTo
    {
        return $this->BelongsTo(Category::class);
    }
}
