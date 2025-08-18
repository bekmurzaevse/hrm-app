<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StageTask extends Model
{
    protected $fillable = [
        'stage_id',
        'title',
        'description',
        'excutor_id',
        'priority',
        'deadline',
        'created_by',
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
        return $this->belongsTo(User::class, 'excutor_id', 'id');
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
