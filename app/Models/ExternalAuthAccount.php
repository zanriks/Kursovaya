<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ExternalAuthAccount extends Model
{
    protected $table = 'external_auth_accounts';
    protected $primaryKey = 'external_auth_account_id';

    public const UPDATED_AT = null;

    protected $fillable = [
        'user_id',
        'provider',
        'provider_user_id',
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
}