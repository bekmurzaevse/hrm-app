<?php

namespace App\Models;

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
        'region',
        'family_status',
        'family_info',
        'status',
        'workplace',
        'position',
        'city',
        'address',
        'salary',
        'desired_salary',
        'source',
        'user_id',
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
            'birth_date' => 'datetime',
        ];
    }

    /**
     * Summary of user
     * @return BelongsTo<User, Candidate>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Summary of contacts
     * @return MorphMany<Contact, Candidate>
     */
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

    public function skills(): MorphMany
    {
        return $this->morphMany(Skill::class, 'skillable');
    }

    public function photo(): MorphOne
    {
        return $this->morphOne(File::class, 'fileable')->where('type', 'photo');
    }
}
