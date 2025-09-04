<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class StatusValue extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'selection_item_id',
        'status_id',
        'value'
    ];

    public $timestamps = false;

    /**
     * Summary of selectionItem
     * @return BelongsTo<SelectionItem, StatusValue>
     */
    public function selectionItem(): BelongsTo
    {
        return $this->belongsTo(SelectionItem::class);
    }

    /**
     * Summary of status
     * @return BelongsTo<SelectionStatus, StatusValue>
     */
    public function status(): BelongsTo
    {
        return $this->belongsTo(SelectionStatus::class);
    }
}