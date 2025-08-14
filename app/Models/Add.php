<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Add extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'addable_type',
        'addable_id',
        'source',
        'status',
        'period_start',
        'period_end',
        'budget',
        'currency',
        'views_count',
        'response_count',
        'created_by',
    ];

    /**
     * Summary of casts
     * @return array{created_at: string, period_end: string, period_start: string, updated_at: string}
     */
    protected function casts(): array
    {
        return [
            'period_start' => 'date',
            'period_end' => 'date',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    /**
     * Summary of source
     * @return Attribute
     */
    protected function source(): Attribute
    {
        return Attribute::make(
            get: fn($value) => ucfirst($value),
            set: fn($value) => trim($value)
        );
    }

    /**
     * Summary of status
     * @return Attribute
     */
    protected function status(): Attribute
    {
        return Attribute::make(
            get: fn($value) => [
                'active' => 'Активна',
                'inactive' => 'Неактивна',
            ][$value],
            set: fn($value) => [
                'Активна' => 'active',
                'Неактивна' => 'inactive',
            ][$value]
        );
    }

    /**
     * Summary of period
     * @return Attribute
     */
    protected function period(): Attribute
    {
        return Attribute::make(
            get: function () {
                return $this->period_start->format('Y-m-d') . ' - ' . $this->period_end->format('Y-m-d');
            }
        );
    }

    /**
     * Summary of budget
     * @return Attribute
     */
    protected function budget(): Attribute
    {
        return Attribute::make(
            get: fn($value) => number_format($value, thousands_separator: ',') . ' ' . $this->currency,
        );
    }

    /**
     * Summary of addable
     * @return MorphTo
     */
    public function addable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Summary of createdBy
     * @return BelongsTo
     */
    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
