<?php

namespace App\Models;

use App\Enums\Task\TaskHistoryType;
use Illuminate\Database\Eloquent\Model;

class TaskHistory extends Model
{
    protected $fillable = [
        'task_id',
        'type',
        'changed_by',
        'comment',
    ];

    protected $casts = [
        'type' => TaskHistoryType::class,
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    public function changedBy()
    {
        return $this->belongsTo(User::class, 'changed_by');
    }
}