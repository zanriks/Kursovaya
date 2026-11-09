<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EstimateItem extends Model
{
    protected $table = 'estimate_items';
    protected $primaryKey = 'estimate_item_id';
    public $timestamps = false;

    protected $fillable = [
        'estimate_id',
        'product_id',
        'description',
        'quantity',
        'unit',
        'unit_price',
        'line_total',
    ];

    protected function casts(): array
    {
        return [
            'unit_price' => 'decimal:2',
            'line_total' => 'decimal:2',
        ];
    }

    public function estimate(): BelongsTo
    {
        return $this->belongsTo(Estimate::class, 'estimate_id', 'estimate_id');
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id', 'product_id');
    }
}