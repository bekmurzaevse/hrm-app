<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WorkExperience extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'company',
        'position',
        'start_work',
        'end_work',
        'candidate_id',
        'description',
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
     * Summary of candidate
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<Candidate, WorkExperience>
     */
    public function candidate()
    {
        return $this->belongsTo(Candidate::class);
    }
}
