<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
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
        'status',
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

    /**
     * Summary of project
     * @return HasOne<Project, Vacancy>
     */
    public function project(): HasOne
    {
        return $this->hasOne(related: Project::class, foreignKey: 'vacancy_id');
    }
}
