<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $table = 'cart';
    protected $primaryKey = 'cart_id';
    public $incrementing = true;
    protected $keyType = 'int';

    public $timestamps = false;

    protected $fillable = [
        'customer_id',
        'product_id',
        'quantity',
        'image',
    ];

    /**
     * Get the customer that owns the cart item.
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'customer_id');
    }

    /**
     * Get the product in the cart.
     */
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'product_id');
    }
}
