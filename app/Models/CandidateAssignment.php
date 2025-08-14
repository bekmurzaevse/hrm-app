<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class CandidateAssignment extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'assignable_type',
        'assignable_id',
        'candidate_id',
        'status',
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
     * Summary of status
     * @return Attribute
     */
    protected function status(): Attribute
    {
        return Attribute::make(
            get: fn($value) => [
                'selected' => 'Отобран',
                'in_review' => 'На рассмотрении',
                'rejected' => 'Отклонен',
            ][$value],
            set: fn($value) => [
                'Отобран' => 'selected',
                'На рассмотрении' => 'in_review',
                'Отклонен' => 'rejected',
            ][$value]
        );
    }

    /**
     * Summary of candidate
     * @return BelongsTo<Candidate>
     */
    public function candidate(): BelongsTo
    {
        return $this->belongsTo(Candidate::class);
    }

    /**
     * Summary of assignable
     * @return MorphTo<Model, CandidateAssignment>
     */
    public function assignable(): MorphTo
    {
        return $this->morphTo();
    }
}
