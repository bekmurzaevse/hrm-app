<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Stage extends Model
{
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
     * @return array{created_at: string, deadline: string, updated_at: string}
     */
    protected function casts(): array
    {
        return [
            'deadline' => 'date',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    /**
     * Summary of appends
     * @var array
     */
    protected $appends = ['executor_fio'];

    /**
     * Summary of getExecutorFioAttribute
     * @return string
     */
    public function getExecutorFioAttribute()
    {
        return sprintf(
            '%s %s.%s',
            $this->executor->last_name,
            mb_substr($this->executor->first_name, 0, 1, 'UTF-8'),
            mb_substr($this->executor->patronymic, 0, 1, 'UTF-8')
        );
    }

    /**
     * Summary of getStatusAttribute
     * @param mixed $value
     * @return string
     */
    public function getStatusAttribute($value)
    {
        return [
            'completed' => 'Завершен',
            'in_progress' => 'В работе',
            'waiting' => 'Ожидает',
        ][$value];
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
}
