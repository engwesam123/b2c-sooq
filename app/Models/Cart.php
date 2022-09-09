<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = ['cookie_id', 'user_id', 'product_id', 'quantity'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected static function booted()
    {
        static::creating(function ($cart) {
            $cart->id = str()->uuid();
        });
    }

    protected static function booted()
    {
        static::creating(function ($cart) {
            $cart->cookie_id = request()->cookie('cart_id');
        });
    }
}
