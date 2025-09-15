<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SelectionItem extends Model
{
    protected $table = 'selection_items';

    protected $fillable = [
        'selection_id',
        'candidate_id',
        'external_name'
    ];

    public $timestamps = false;

    /**
     * Summary of createdBy
     * @return BelongsTo<User, Selection>
     */
    public function selection(): BelongsTo
    {
        return $this->belongsTo(Selection::class, 'selection_id');
    }

    /**
     * Summary of candidate
     * @return BelongsTo<Candidate, SelectionItem>
     */
    public function candidate(): BelongsTo
    {
        return $this->belongsTo(Candidate::class, 'candidate_id');
    }

    /**
     * Summary of statusValues
     * @return HasMany<SelectionStatusValue, SelectionItem>
     */
    public function statusValues(): HasMany
    {
        return $this->hasMany(SelectionStatusValue::class, 'selection_item_id');
    }
}
