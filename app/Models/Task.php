<?php

namespace App\Models;

use App\Enums\Task\TaskPriorityEnum;
use App\Enums\Task\TaskStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;                      
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

    /**
     * Summary of deadlineHuman
     * @return Attribute
     */
    protected function deadlineHuman(): Attribute
    {
        return Attribute::make(
            get: function () {

                $today = now()->startOfDay();
                $diff = (int) $today->diffInDays($this->deadline, false);

                return match (true) {
                    $diff < 0 => "Просрочена на " . abs($diff) . " дн.",
                    $diff === 0 => 'Сегодня',
                    $diff === 1 => 'Завтра',
                    $diff > 1 && $diff <= 10 => "Через {$diff} дней",
                    default => $this->deadline->format('Y-m-d'),
                };
            }
        );
    }

    /**
     * Deadline rang accessor
     */
    protected function urgencyColor(): Attribute
    {
        return Attribute::make(
            get: function () {
                $today = Carbon::today();
                $diff = (int) $today->diffInDays($this->deadline, false);

                return match (true) {
                    $diff <= 0 => 'red',    // просрочено, сегодня
                    $diff <= 3 => 'yellow', // Завтра yoki 2–3 дня
                    $diff <= 10 => 'green',  // 4–10 дней
                    default => 'gray',   // boshqa
                };
            }
        );
    }

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
