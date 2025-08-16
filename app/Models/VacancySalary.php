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
        'salary',
        'salary_from',
        'salary_to',
        'currency',
        'period',
        'bonus',
        'probation',
        'probation_salary',
    ];

    // TODO: Currency not sure, maybe should be enum

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
                // Split the value into parts based on the hyphen
                $value = trim($value);
                $parts = explode('-', $value);

                $from = trim($parts[0]);

                $to = isset($parts[1]) ? trim($parts[1]) : 0;

                return [
                    'salary_from' => $from,
                    'salary_to' => $to,
                ];
            }
        );
    }

    /**
     * Summary of salaryDetail
     * @return Attribute
     */
    protected function salaryDetail(): Attribute
    {
        return Attribute::make(
            get: function () {
                $salary = $this->salary;
                $period = $this->period;

                return $salary . ' ' . $period; // 1000 RUB В месяц, 1000-2000 RUB В месяц
            }
        );
    }

    /**
     * Summary of period
     * @return Attribute
     */
    protected function period(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                $map = [
                    'hour' => 'В час',
                    'day' => 'В день',
                    'week' => 'В неделю',
                    'month' => 'В месяц',
                ];

                return $map[$value];
            },
            set: function ($value) {
                $map = [
                    'В час' => 'hour',
                    'В день' => 'day',
                    'В неделю' => 'week',
                    'В месяц' => 'month',
                ];

                return $map[$value];
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
