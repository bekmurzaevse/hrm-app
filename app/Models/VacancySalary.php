<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class VacancySalary extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'vacancy_id',
        'salary_from',
        'salary_to',
        'currency',
        'period',
        'bonus',
        'probation',
        'probation_salary',
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
     * Summary of salary
     * @return Attribute
     */
    protected function salary(): Attribute
    {
        return Attribute::make(
            get: function ($value, $attributes) {
                $currency = $attributes['currency'];

                if (isset($attributes['salary_from']) && isset($attributes['salary_to'])) {
                    if ($attributes['salary_to'] === 0) {
                        return $attributes['salary_from'] . ' ' . $currency; // 1000 RUB
                    }

                    return $attributes['salary_from'] . '-' . $attributes['salary_to'] . ' ' . $currency; // 1000-2000 RUB
                }
            },
            set: function ($value) {
                // Remove non-numeric characters except spaces and hyphens
                $value = preg_replace('/[^0-9\s-]/', '', $value);

                // Split the value into parts based on the hyphen
                $parts = explode('-', $value);

                $from = (int) trim($parts[0]);

                $to = isset($parts[1]) ? (int) trim($parts[1]) : 0;

                return [
                    'salary_from' => $from,
                    'salary_to' => $to,
                ];
            }
        );
    }

    /**
     * Summary of vacancy
     * @return BelongsTo<Vacancy, VacancyDetail>
     */
    public function vacancy(): BelongsTo
    {
        return $this->belongsTo(related: Vacancy::class);
    }
}
