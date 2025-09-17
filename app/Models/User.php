<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Enums\User\UserStatusEnum;
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
     * Summary of projects
     * @return BelongsToMany<Project, User, \Illuminate\Database\Eloquent\Relations\Pivot>
     */
    public function projects(): BelongsToMany
    {
        return $this->belongsToMany(Project::class);
    }

    /**
     * Summary of activities
     * @return HasMany<UserActivity, User>
     */
    public function activities(): HasMany
    {
        return $this->hasMany(UserActivity::class)->with('user');
    }

    public function finances(): HasMany
    {
        return $this->hasMany(Finance::class);
    }

    public function tasks()
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
  
    public function assignedTasks(): BelongsToMany
    {
        return $this->belongsToMany(Task::class, 'task_users');
    }
}
