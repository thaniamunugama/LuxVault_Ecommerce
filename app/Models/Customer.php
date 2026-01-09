<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class Customer extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens, HasProfilePhoto, TwoFactorAuthenticatable;

    protected $primaryKey = 'customer_id';
    public $incrementing = true;
    protected $keyType = 'int';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'fname',
        'lname',
        'email',
        'phone',
        'password',
        'profile_photo_path',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'two_factor_confirmed_at' => 'datetime',
        ];
    }

    /**
     * Get the orders for the customer.
     */
    public function orders()
    {
        return $this->hasMany(Order::class, 'customer_id', 'customer_id');
    }

    /**
     * Get the cart items for the customer.
     */
    public function cartItems()
    {
        return $this->hasMany(Cart::class, 'customer_id', 'customer_id');
    }
}
