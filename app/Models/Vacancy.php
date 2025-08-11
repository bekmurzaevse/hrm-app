<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vacancy extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'client_id',
        'salary',
        'salary_period',
        'city',
        'user_id',
        'status',
        'type_employment',
        'temporary_from',
        'temporary_to',
        'KPI',
        'probation_period',
        'probation_salary',
        'employee_count',
        'description',
    ];

    /**
     * Summary of casts
     * @return array{created_at: string, updated_at: string}
     */
    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    /**
     * Summary of clients
     * @return HasMany<Client, Vacancy>
     */
    public function clients(): HasMany
    {
        return $this->hasMany(Client::class);
    }

}
