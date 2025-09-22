<?php

namespace App\Models;

use App\Enums\StageStatusEnum;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Stage extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'deadline',
        'is_required',
        'created_by',
        'order',
        'status',
        'project_id',
        'executor_id',
    ];

    /**
     * Summary of casts
     * @return array{created_at: string, deadline: string, status: string, updated_at: string}
     */
    protected function casts(): array
    {
        return [
            'status' => StageStatusEnum::class,
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
     * Summary of project
     * @return BelongsTo<Project, Stage>
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * Summary of createdBy
     * @return BelongsTo<User, Stage>
     */
    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Summary of executor
     * @return BelongsTo<User, Stage>
     */
    public function executor(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Summary of stageTasks
     * @return HasMany<StageTask, Stage>
     */
    public function stageTasks(): HasMany
    {
        return $this->hasMany(StageTask::class);
    }

    /**
     * Summary of stageCompletions
     * @return HasOne<StageCompletion, Stage>
     */
    public function stageCompletion(): HasOne
    {
        return $this->hasOne(StageCompletion::class);
    }
}
