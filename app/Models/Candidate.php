<?php

namespace App\Models;

use App\Enums\Candidate\CandidateStatusEnum;
use App\Enums\Candidate\FamilyStatusEnum;
use App\Enums\GenderEnum;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Candidate extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'first_name',
        'last_name',
        'patronymic',
        'birth_date',
        'gender',
        'citizenship',
        'country_residence',
        'family_status',
        'family_info',
        'status',
        'workplace',
        'position',
        'district_id',
        'address',
        'salary',
        'desired_salary',
        'source',
        'user_id',
        'experience',
        'short_summary',
        'achievments',
        'comment',
        'description',
    ];

    /**
     * Summary of casts
     * @return array{created_at: string, updated_at: string}
     */
    protected function casts(): array
    {
        return [
            'gender' => GenderEnum::class,
            'family_status' => FamilyStatusEnum::class,
            'status' => CandidateStatusEnum::class,
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'birth_date' => 'date',
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
     * Summary of user
     * @return BelongsTo<User, Candidate>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function contacts(): MorphMany
    {
        return $this->morphMany(Contact::class, 'contactable');
    }

    /**
     * Summary of educations
     * @return HasMany<Education, Candidate>
     */
    public function educations(): HasMany
    {
        return $this->hasMany(Education::class);
    }

    /**
     * Summary of interactions
     * @return HasMany<Interaction, Candidate>
     */
    public function interactions(): HasMany
    {
        return $this->hasMany(Interaction::class);
    }

    /**
     * Summary of workExperience
     * @return HasMany<WorkExperience, Candidate>
     */
    public function workExperience(): HasMany
    {
        return $this->hasMany(WorkExperience::class);
    }

    /**
     * Summary of files
     * @return MorphMany<File, Candidate>
     */
    public function files(): MorphMany
    {
        return $this->morphMany(File::class, 'fileable');
    }

    /**
     * Summary of skills
     * @return MorphMany<Skill, Candidate>
     */
    public function skills(): MorphMany
    {
        return $this->morphMany(Skill::class, 'skillable');
    }

    /**
     * Summary of photo
     * @return MorphOne<File, Candidate>
     */
    public function photo(): MorphOne
    {
        return $this->morphOne(File::class, 'fileable')->where('type', 'photo');
    }

    /**
     * Summary of languages
     * @return HasMany<Language, Candidate>
     */
    public function languages(): HasMany
    {
        return $this->hasMany(Language::class);
    }

    /**
     * Summary of district
     * @return BelongsTo<District, Candidate>
     */
    public function district(): BelongsTo
    {
        return $this->belongsTo(District::class);
    }

    /**
     * Summary of getTotalWorkExperienceAttribute
     * @return string
     */
    public function getTotalWorkExperienceAttribute()
    {
        $totalMonths = 0;

        foreach ($this->workExperience as $exp) {
            $start = Carbon::parse($exp->start_work);
            $end = $exp->end_work ? Carbon::parse($exp->end_work) : Carbon::now();

            $totalMonths += $start->diffInMonths($end);
        }

        $years = floor($totalMonths / 12);
        $months = $totalMonths % 12;

        // return "{$years} год {$months} месяц";
        return $months != 0 ? "{$years} год {$months} месяц" : "{$years} год";
    }
}
