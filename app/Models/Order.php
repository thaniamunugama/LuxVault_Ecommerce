<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $primaryKey = 'order_id';
    public $incrementing = true;
    protected $keyType = 'int';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'customer_id',
        'total_price',
        'order_date',
        'status',
        'shipping_first_name',
        'shipping_last_name',
        'shipping_phone',
        'shipping_address',
        'shipping_city',
        'shipping_state',
        'shipping_postal_code',
        'shipping_country',
    ];

    /**
     * Get the customer that owns the order.
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'customer_id');
    }

    /**
     * Get the order items for the order.
     */
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'order_id', 'order_id');
    }
}
