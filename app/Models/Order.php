<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'email', 'phoneNumber', 'status', 'delivery_way',
        'payment_method', 'price', 'table_id', 'starDelivery',
        'finishDelivery', 'address', 'user_id'
    ];

    protected $casts = [
        'price' => 'float',
    ];

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class)->withPivot(['quantity', 'price']);
    }
}
