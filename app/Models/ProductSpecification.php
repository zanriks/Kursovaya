<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductSpecification extends Model
{
    protected $table = 'product_specifications';
    protected $primaryKey = 'product_specification_id';
    public $timestamps = false;

    protected $fillable = [
        'product_id',
        'name',
        'value',
        'sort_order',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id', 'product_id');
    }
}