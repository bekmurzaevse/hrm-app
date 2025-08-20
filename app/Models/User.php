<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes, HasRoles;

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
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // public function projects(): HasMany
    // {
    //     return $this->hasMany(Project::class);
    // }

    // public function projects(): BelongsToMany
    // {
    //     return $this->belongsToMany(Project::class, 'project_user', 'user_id', 'project_id');
    // }

    public function projects(): BelongsToMany
    {
        return $this->belongsToMany(Project::class);
    }

    public function activities(): HasMany
    {
        return $this->hasMany(UserActivity::class)->with('user');
    }

}
