<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Selection extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title',
        'created_by',
    ];

    /**
     * Summary of casts
     * @return array{created_at: string, updated_at: string}
     */
    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    /**
     * Summary of createdBy
     * @return BelongsTo<User, Selection>
     */
    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Summary of items
     * @return HasMany<SelectionItem, Selection>
     */
    public function items(): HasMany
    {
        return $this->hasMany(SelectionItem::class);
    }

    /**
     * Summary of status
     * @return HasMany<SelectionStatus, Selection>
     */
    public function status(): HasMany
    {
        return $this->hasMany(SelectionStatus::class);
    }
}