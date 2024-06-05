<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'email', 'address', 'phoneNumber', 'delivery_way', 'payment_method',
        'table_id', 'price', 'starDelivery',  'finishDelivery', 'status'
    ];

    protected $casts = [
        'price' => 'float',
    ];


    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class);
    }
}
