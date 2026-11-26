<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Favorite extends Model
{
    protected $table = 'favorites';
    protected $primaryKey = 'favorite_id';

    public const UPDATED_AT = null;

    protected $fillable = [
        'user_id',
        'product_id',
    ];

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id', 'product_id');
    }

    // какие товары уже в избранном
    public static function idsForUser(?int $userId)
    {
        if (! $userId) {
            return collect();
        }

        return static::query()
            ->where('user_id', $userId)
            ->pluck('product_id')
            ->flip();
    }
}