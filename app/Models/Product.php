<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $primaryKey = 'product_id';
    public $incrementing = true;
    protected $keyType = 'int';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'seller_id',
        'brand',
        'name',
        'description',
        'quantity',
        'price',
        'image',
    ];

    /**
     * Get the seller that owns the product.
     */
    public function seller()
    {
        return $this->belongsTo(Seller::class, 'seller_id', 'seller_id');
    }
}
