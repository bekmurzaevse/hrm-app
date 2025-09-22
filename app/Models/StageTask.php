<?php

namespace App\Models;

use App\Enums\StageTaskPriorityEnum;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class StageTask extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'stage_id',
        'title',
        'description',
        'executor_id',
        'priority',
        'deadline',
        'created_by',
    ];

    /**
     * Summary of casts
     * @return array{created_at: string, deadline: string, priority: string, updated_at: string}
     */
    protected function casts(): array
    {
        return [
            'priority' => StageTaskPriorityEnum::class,
            'deadline' => 'date',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    /**
     * Summary of deadline
     * @return Attribute
     */
    protected function deadline(): Attribute
    {
        return Attribute::make(
            set: fn($value) => Carbon::createFromFormat('m-d-Y', $value),
        );
    }

    /**
     * Summary of stage
     * @return BelongsTo<Stage, StageTask>
     */
    public function stage(): BelongsTo
    {
        return $this->belongsTo(Stage::class);
    }

    /**
     * Summary of executor
     * @return BelongsTo<User, StageTask>
     */
    public function executor(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Summary of creator
     * @return BelongsTo<User, StageTask>
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
}
