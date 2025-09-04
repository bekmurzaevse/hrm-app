<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class SelectionStatus extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'selection_id',
        'title',
        'order'
    ];

    public $timestamps = false;

    /**
     * Summary of selection
     * @return BelongsTo<Selection, SelectionStatus>
     */
    public function selection(): BelongsTo
    {
        return $this->belongsTo(Selection::class);
    }

    /**
     * Summary of values
     * @return HasMany<StatusValue, SelectionStatus>
     */
    public function values(): HasMany
    {
        return $this->hasMany(StatusValue::class);
    }
}