<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SelectionStatusValue extends Model
{
    protected $table = 'selection_status_values';

    protected $fillable = [
        'selection_item_id',
        'selection_status_id',
        'value'
    ];

    public $timestamps = false;

    /**
     * Summary of item
     * @return BelongsTo<SelectionItem, SelectionStatusValue>
     */
    public function item(): BelongsTo
    {
        return $this->belongsTo(SelectionItem::class, 'selection_item_id');
    }

    /**
     * Summary of status
     * @return BelongsTo<SelectionStatus, SelectionStatusValue>
     */
    public function status(): BelongsTo
    {
        return $this->belongsTo(SelectionStatus::class, 'selection_status_id');
    }
}
