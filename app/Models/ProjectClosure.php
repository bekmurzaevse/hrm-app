<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProjectClosure extends Model
{
    public $timestamps = false;

    protected $table = 'project_closures';

    protected $fillable = [
        'project_id',
        'closed_by',
        'comment',
        'closed_at',
    ];

    /**
     * Summary of casts
     * @return array{closed_at: string}
     */
    protected function casts(): array
    {
        return [
            'closed_at' => 'date',
        ];
    }

    /**
     * Summary of project
     * @return BelongsTo<Project, ProjectClosure>
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * Summary of closedBy
     * @return BelongsTo<User, ProjectClosure>
     */
    public function closedBy(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
