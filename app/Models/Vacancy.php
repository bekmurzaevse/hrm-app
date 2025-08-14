<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
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
        'priority',
        'deadline',
        'manager_id',
        'recruiter_id',
        'created_by',
        'comment',
        'position_count',
    ];


    /**
     * Summary of casts
     * @return array{created_at: string, deadline: string, updated_at: string}
     */
    protected function casts(): array
    {
        return [
            'deadline' => 'date',
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
                'open' => 'Открыта',
                'in_progress' => 'В работе',
                'closed' => 'Закрыта',
                'paused' => 'Приостановлена',
            ][$value],
            set: fn($value) => [
                'Открыта' => 'open',
                'В работе' => 'in_progress',
                'Закрыта' => 'closed',
                'Приостановлена' => 'paused',
            ][$value]
        );
    }

    /**
     * Summary of priority
     * @return Attribute
     */
    protected function priority(): Attribute
    {
        return Attribute::make(
            get: fn($value) => [
                'low' => 'Низкий',
                'medium' => 'Средний',
                'high' => 'Высокий',
            ][$value],
            set: fn($value) => [
                'Низкий' => 'low',
                'Средний' => 'medium',
                'Высокий' => 'high',
            ][$value]
        );
    }

    /**
     * Summary of setDeadlineAttribute
     * @param mixed $value
     * @return void
     */
    public function setDeadlineAttribute($value): void
    {
        $this->attributes['deadline'] = Carbon::createFromFormat('m-d-Y', $value)->format('Y-m-d');
    }

    /**
     * Summary of manager
     * @return BelongsTo<User, Vacancy>
     */
    public function manager(): BelongsTo
    {
        return $this->belongsTo(related: User::class, foreignKey: 'manager_id');
    }

    /**
     * Summary of recruiter
     * @return BelongsTo<User, Vacancy>
     */
    public function recruiter(): BelongsTo
    {
        return $this->belongsTo(related: User::class, foreignKey: 'recruiter_id');
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
     * Summary of tags
     * @return BelongsToMany<Tag, Vacancy>, <vacancy_tag, vacancy_id, tag_id>
     */
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'vacancy_tag', 'vacancy_id', 'tag_id');
    }

    /**
     * Summary of vacancyDetail
     * @return HasOne<VacancyDetail, Vacancy>
     */
    public function vacancyDetail(): HasOne
    {
        return $this->hasOne(VacancyDetail::class, 'vacancy_id');
    }

    /**
     * Summary of adds
     * @return MorphMany<Add, Vacancy>
     */
    public function adds(): MorphMany
    {
        return $this->morphMany(Add::class, 'addable');
    }

    /**
     * Summary of candidates
     * @return MorphMany<Candidate, Vacancy>
     */
    public function candidates(): MorphMany
    {
        return $this->morphMany(Candidate::class, 'assignable');
    }

    /**
     * Summary of vacancySalary
     * @return HasOne<VacancySalary, Vacancy>
     */
    public function vacancySalary(): HasOne
    {
        return $this->hasOne(VacancySalary::class, 'vacancy_id');
    }

    /**
     * Summary of vacancyContact
     * @return HasOne<VacancyContact, Vacancy>
     */
    public function vacancyContact(): HasOne
    {
        return $this->hasOne(VacancyContact::class, 'vacancy_id');
    }

    /**
     * Summary of candidates
     * @return MorphMany<Candidate, Vacancy>
     */
    public function skills(): MorphMany
    {
        return $this->morphMany(Skill::class, 'skillable');
    }

    // TODO: add Project - relationships for project_vacancy,
    // public function projects()
    // {
    //     return $this->belongsToMany(Project::class, 'project_vacancy', 'vacancy_id', 'project_id');
    // }

}
