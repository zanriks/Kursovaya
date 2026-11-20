<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CartItem extends Model
{
    protected $table = 'cart_items';
    protected $primaryKey = 'cart_item_id';
    public $timestamps = false;

    protected $fillable = [
        'cart_id',
        'product_id',
        'quantity',
        'price_at_add',
    ];

    protected function casts(): array
    {
        return [
            'price_at_add' => 'decimal:2',
        ];
    }

    public function cart(): BelongsTo
    {
        return $this->belongsTo(Cart::class, 'cart_id', 'cart_id');
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id', 'product_id');
    }

    public static function forUserKeyedByProduct(?int $userId)
    {
        if (!$userId) {
            return collect();
        }

        return static::query()
            ->whereHas('cart', function ($query) use ($userId) {
                $query->where('user_id', $userId)
                    ->where('status', 'active');
            })
            ->get()
            ->keyBy('product_id');
    }
}