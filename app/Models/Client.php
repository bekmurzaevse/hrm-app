<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'status',
        'leader',
        'contact_person',
        'person_position',
        'person_phone',
        'person_email',
        'phone',
        'email',
        'address',
        'user_id',
        'INN',
        'employee_count',
        'source',
        'activity',
        'description',
        'notes',
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
     * Summary of contactPersons
     * @return HasMany<ContactPerson, Client>
     */
    public function contactPersons(): HasMany
    {
        return $this->hasMany(ContactPerson::class);
    }

    /**
     * Summary of vacancies
     * @return HasMany<Vacancy, Client>
     */
    public function vacancies(): HasMany
    {
        return $this->hasMany(Vacancy::class);
    }

    /**
     * Summary of candidates
     * @return HasMany<Candidate, Client>
     */
    public function candidates(): HasMany
    {
        return $this->hasMany(Candidate::class);
    }

    public function files(): MorphMany
    {
        return $this->morphMany(File::class, 'fileable');
    }

    /**
     * Summary of contacts
     * @return MorphMany<Contact, Client>
     */
    public function contacts(): MorphMany
    {
        return $this->morphMany(Contact::class, 'contactable');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function projects(): HasMany
    {
        return $this->hasMany(Project::class);
    }

}
