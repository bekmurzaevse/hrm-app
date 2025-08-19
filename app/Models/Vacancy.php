<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vacancy extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'client_id',
        'department',
        'city',
        'type_employment',
        'work_schedule',
        'work_experience',
        'education',
        'satus',
        'position_count',
        'created_by',
        'salary',
        'salary_from',
        'salary_to',
        'currency',
        'period',
        'bonus',
        'probation',
        'probation_salary',
        'description',
        'requirements',
        'responsibilities',
        'work_conditions',
        'benefits',
    ];


    /**
     * Summary of casts
     * @return array{created_at: string, deadline: string, updated_at: string}
     */
    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
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
     * Summary of typeEmployment
     * @return Attribute
     */
    protected function typeEmployment(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                $map = [
                    'office' => 'В офисе',
                    'remote' => 'Удаленно',
                    'tempororary' => 'Временная занятость',
                    'internship' => 'Стажировка',
                    'hybrid' => 'Гибридная работа',
                ];

                return $map[$value];
            },
            set: function ($value) {
                $map = [
                    'В офисе' => 'office',
                    'Удаленно' => 'remote',
                    'Временная занятость' => 'tempororary',
                    'Стажировка' => 'internship',
                    'Гибридная работа' => 'hybrid',
                ];

                return $map[$value];
            }
        );
    }

    /**
     * Summary of workSchedule
     * @return Attribute
     */
    protected function workSchedule(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                $map = [
                    'full_time' => 'Полный день',
                    'flexible' => 'Гибкий график',
                    'remote' => 'Удаленная работа',
                    'shift' => 'Сменный график',
                ];

                return $map[$value];
            },
            set: function ($value) {
                $map = [
                    'Полный день' => 'full_time',
                    'Гибкий график' => 'flexible',
                    'Удаленная работа' => 'remote',
                    'Сменный график' => 'shift',
                ];

                return $map[$value];
            }
        );
    }

    /**
     * Summary of workExperience
     * @return Attribute
     */
    protected function workExperience(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                $map = [
                    'no_experience' => 'Без опыта',
                    'one_to_three' => '1-3 года',
                    'three_to_six' => '3-6 лет',
                    'over_six' => 'Более 6 лет',
                ];

                return $map[$value];
            },
            set: function ($value) {
                $map = [
                    'Без опыта' => 'no_experience',
                    '1-3 года' => 'one_to_three',
                    '3-6 лет' => 'three_to_six',
                    'Более 6 лет' => 'over_six',
                ];

                return $map[$value];
            }
        );
    }

    /**
     * Summary of education
     * @return Attribute
     */
    protected function education(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                $map = [
                    'secondary' => 'Среднее',
                    'secondary_vocational' => 'Среднее специальное',
                    'incomplete_higher' => 'Неоконченное высшее',
                    'higher' => 'Высшее',
                ];

                return $map[$value];
            },
            set: function ($value) {
                $map = [
                    'Среднее' => 'secondary',
                    'Среднее специальное' => 'secondary_vocational',
                    'Неоконченное высшее' => 'incomplete_higher',
                    'Высшее' => 'higher',
                ];

                return $map[$value];
            }
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
                'not_active' => 'Не активна',
                'open' => 'Открыта',
                'closed' => 'Закрыта',
                'not_closed' => 'Не закрыта',
            ][$value],
            set: fn($value) => [
                'Не активна' => 'not_active',
                'Открыта' => 'open',
                'Закрыта' => 'closed',
                'Не закрыта' => 'not_closed',
            ][$value]
        );
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
     * Summary of creator
     * @return Attribute
     */
    protected function creator(): Attribute
    {
        return Attribute::make(
            get: function () {
                return sprintf(
                    '%s %s.%s',
                    $this->createdBy->last_name,
                    mb_substr($this->createdBy->first_name, 0, 1, 'UTF-8'),
                    mb_substr($this->createdBy->patronymic, 0, 1, 'UTF-8')
                );
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

    /**
     * Summary of skills
     * @return MorphMany<Skill, Vacancy>
     */
    public function skills(): MorphMany
    {
        return $this->morphMany(related: Skill::class, name: 'skillable');
    }

    /**
     * Summary of files
     * @return MorphMany<File, Vacancy>
     */
    public function files(): MorphMany
    {
        return $this->morphMany(related: File::class, name: 'fileable');
    }

    // TODO: Implement OneToOne relationships for Project
}
