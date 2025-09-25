<?php

namespace App\Models;

use App\Enums\Task\TaskStatusEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TaskUser extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'task_id',
        'user_id',
        'assigned_at',
        'accepted_at',
        'status',
    ];

    protected $casts = [
        'status' => TaskStatusEnum::class,
        'assigned_at' => 'datetime',
        'accepted_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
