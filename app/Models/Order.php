<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_code',
        'total',
        'note',
        'status',
        'arrival',
        'customer_id'
    ];

    protected $with = [
        // 'customer',
        // 'products',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class)->withPivot(['price', 'quantity', 'stock_id']);
    }
}
