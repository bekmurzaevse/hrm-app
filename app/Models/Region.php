<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Region extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title',
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
     * Summary of candidates
     * @return HasMany<Candidate, Region>
     */
    public function candidates(): HasMany
    {
        return $this->hasMany(Candidate::class);
    }
}
