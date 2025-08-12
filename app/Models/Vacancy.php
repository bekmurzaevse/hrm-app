<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vacancy extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'client_id',
        'title',
        'description',
        'city',
        'type_employment',
        'temporary_from',
        'temporary_to',
        'salary_min',
        'salary_max',
        'salary_period',
        'created_by',
        'status',
        'probation_period_value',
        'probation_period_unit',
        'probation_salary_amount',
        'probation_salary_period',
        'experience_min',
        'experience_max',
        'employee_count',
    ];


    /**
     * Summary of casts
     * @return array{created_at: string, employee_count: string, experience_max: string, experience_min: string, probation_period_value: string, probation_salary_amount: string, salary_max: string, salary_min: string, temporary_from: string, temporary_to: string, updated_at: string}
     */
    protected function casts(): array
    {
        return [
            'temporary_from' => 'date',
            'temporary_to' => 'date',
            'salary_min' => 'decimal:2',
            'salary_max' => 'decimal:2',
            'probation_salary_amount' => 'decimal:2',
            'probation_period_value' => 'integer',
            'experience_min' => 'integer',
            'experience_max' => 'integer',
            'employee_count' => 'integer',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    /**
     * Summary of typeEmployment
     * @return Attribute
     */
    protected function typeEmployment(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                $map = [
                    'office' => 'В офисе',
                    'remote' => 'Удалённая работа',
                    'temporary' => 'Временная работа',
                    'internship' => 'Стажировка',
                ];

                return $map[$value];
            }
        );
    }

    /**
     * Summary of title
     * @return Attribute
     */
    protected function title(): Attribute
    {
        return Attribute::make(
            get: fn($value) => ucfirst($value),
            set: fn($value) => trim($value)
        );
    }

    /**
     * Summary of status
     * @return Attribute
     */
    protected function status(): Attribute
    {
        return Attribute::make(
            get: fn($value) => [
                'in_active' => 'Не активна',
                'open' => 'Открыта',
                'closed' => 'Закрыта',
                'not_closed' => 'Не закрыта',
            ][$value]
        );
    }

    /**
     * Summary of experience
     * @return Attribute
     */
    protected function experience(): Attribute
    {
        return Attribute::make(
            get: function () {
                $formatYears = function ($years) {
                    $lastDigit = $years % 10;
                    $lastTwoDigits = $years % 100;

                    if ($lastTwoDigits >= 11 && $lastTwoDigits <= 14) {
                        return "{$years} лет";
                    }
                    if ($lastDigit === 1) {
                        return "{$years} год";
                    }
                    if ($lastDigit >= 2 && $lastDigit <= 4) {
                        return "{$years} года";
                    }
                    return "{$years} лет";
                };

                if ($this->experience_min === 0 && $this->experience_max === 0) {
                    return 'Без опыта';
                } // Без опыта
    
                if ($this->experience_min && is_null($this->experience_max)) {
                    return $formatYears($this->experience_min) . '+';
                } // 1 год+, 3 лет+
    
                if (!is_null($this->experience_min) && !is_null($this->experience_max)) {
                    return "{$this->experience_min}-" . $formatYears($this->experience_max);
                } // 1 - 3 года, 1 - 4 лет
            }
        );
    }

    /**
     * Summary of salary
     * @return Attribute
     */
    public function salary(): Attribute
    {
        return Attribute::make(
            get: function () {
                $min = number_format((float) $this->salary_min, 0, '.', ' ');
                if ($this->salary_max === null) {
                    return "{$min}+";
                } // 1 000 000+
    
                $max = number_format((float) $this->salary_max, 0, '.', ' ');
                return "{$min} - {$max}"; // 1 000 000 - 2 000 000
            }
        );
    }

    /**
     * Summary of probationPeriod
     * @return Attribute
     */
    protected function probationPeriod(): Attribute
    {
        return Attribute::make(
            get: function () {
                if (!$this->probation_period_value && !$this->probation_period_unit) {
                    return null;
                }

                $units = [
                    'day' => 'день',
                    'days' => 'дня',
                    'month' => 'месяц',
                    'months' => 'месяца',
                ];

                $unit = $units[$this->probation_period_unit];

                return "{$this->probation_period_value} {$unit}";
            }
        );
    }

    /**
     * Summary of creator
     * @return BelongsTo<User, Vacancy>
     */
    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(related: User::class, foreignKey: 'created_by');
    }

    /**
     * Summary of client
     * @return BelongsTo<Client, Vacancy>
     */
    public function client(): BelongsTo
    {
        return $this->belongsTo(related: Client::class, foreignKey: 'client_id');
    }
}
