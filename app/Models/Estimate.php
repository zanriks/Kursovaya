<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Estimate extends Model
{
    protected $table = 'estimates';
    protected $primaryKey = 'estimate_id';

    public const UPDATED_AT = null;

    protected $fillable = [
        'user_id',
        'name',
        'parameters',
        'total_amount',
    ];

    protected function casts(): array
    {
        return [
            'parameters' => 'array',
            'total_amount' => 'decimal:2',
            'created_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function items(): HasMany
    {
        return $this->hasMany(EstimateItem::class, 'estimate_id', 'estimate_id');
    }
}