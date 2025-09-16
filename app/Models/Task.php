<?php

namespace App\Models;

use App\Enums\Task\TaskPriorityEnum;
use App\Enums\Task\TaskStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use SoftDeletes, HasFactory;

    protected $fillable = [
        'title',
        'description',
        'deadline',
        'created_by',
        'status',
        'priority',
        'comment'
    ];

    protected $casts = [
        'status' => TaskStatusEnum::class,
        'priority' => TaskPriorityEnum::class,
        'deadline' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function executors()
    {
        return $this->belongsToMany(User::class, 'task_users');
    }

    public function taskUsers()
    {
        return $this->hasMany(TaskUser::class);
    }

    public function history()
    {
        return $this->hasMany(TaskHistory::class);
    }
}
