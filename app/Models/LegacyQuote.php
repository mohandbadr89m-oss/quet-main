<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LegacyQuote extends Model
{
    /**
     * Attributes that can be mass assigned.
     */
    protected $fillable = [
        'content',
        'speaker',
        'speaker_bio',
        'category',
        'is_featured',
        'created_by',
    ];

    /**
     * Attribute casting.
     */
    protected function casts(): array
    {
        return [
            'is_featured' => 'boolean',
        ];
    }

    /**
     * Admin or Owner who created this legacy quote.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
