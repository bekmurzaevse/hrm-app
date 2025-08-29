<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

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
     * Summary of districts
     * @return HasMany<District, Region>
     */
    public function districts(): HasMany
    {
        return $this->hasMany(District::class);
    }

    /**
     * Summary of candidates
     * @return HasManyThrough<Candidate, District, Region>
     */
    public function candidates(): HasManyThrough
    {
        return $this->hasManyThrough(
            Candidate::class,
            District::class,
            'region_id',
            'district_id',
            'id',
            'id'
        );
    }
}
