<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class VacancyContact extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'vacancy_id',
        'name',
        'position',
        'phone',
        'email',
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
     * Summary of vacancy
     * @return BelongsTo<Vacancy, VacancyDetail>
     */
    public function vacancy(): BelongsTo
    {
        return $this->belongsTo(related: Vacancy::class);
    }
}
