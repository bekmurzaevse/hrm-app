<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Enums\User\UserStatusEnum;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes, HasRoles, HasApiTokens;

    protected $fillable = [
        'first_name',
        'last_name',
        'patronymic',
        'birth_date',
        'address',
        'position',
        'status',
        'phone',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'status' => UserStatusEnum::class,
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Summary of creator
     * @return Attribute
     */
    protected function shortFio(): Attribute
    {
        return Attribute::make(
            get: function () {
                return sprintf(
                    '%s %s.%s',
                    $this->last_name,
                    mb_substr($this->first_name, 0, 1, 'UTF-8'),
                    mb_substr($this->patronymic, 0, 1, 'UTF-8')
                );
            }
        );
    }

    /**
     * Summary of project
     * @return HasMany<Project, User>
     */
    public function projects(): HasMany
    {
        return $this->hasMany(Project::class, 'executor_id');
    }

    /**
     * Summary of activities
     * @return HasMany<UserActivity, User>
     */
    public function activities(): HasMany
    {
        return $this->hasMany(UserActivity::class)->with('user');
    }

    /**
     * Summary of finances
     * @return HasMany<Finance, User>
     */
    public function finances(): HasMany
    {
        return $this->hasMany(Finance::class);
    }

    /**
     * Summary of tasks
     * @return HasMany<Task, User>
     */
    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class, 'created_by');
    }

    /**
     * Summary of vacancies
     * @return HasMany<Vacancy, User>
     */
    public function vacancies(): HasMany
    {
        return $this->hasMany(Vacancy::class, 'created_by');
    }

    /**
     * Summary of assignedTasks
     * @return BelongsToMany<Task, User, \Illuminate\Database\Eloquent\Relations\Pivot>
     */
    public function assignedTasks(): BelongsToMany
    {
        return $this->belongsToMany(Task::class, 'task_users');
    }
}
