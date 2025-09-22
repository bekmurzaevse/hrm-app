<?php

namespace App\Models;

use App\Enums\ProjectStatusEnum;
use App\Enums\StageStatusEnum;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title',
        'client_id',
        'vacancy_id',
        'deadline',
        'contract_number',
        'contract_budget',
        'contract_currency',
        'description',
        'comment',
        'created_by',
        'status'
    ];

    /**
     * Summary of casts
     * @return array{created_at: string, deadline: string, status: string, updated_at: string}
     */
    protected function casts(): array
    {
        return [
            'status' => ProjectStatusEnum::class,
            'deadline' => 'date',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    /**
     * Summary of getProgressAttribute
     * @return string
     */
    public function getProgressAttribute(): string
    {
        $total = $this->stages->count();
        $completed = $this->stages->where('status', StageStatusEnum::COMPLETED)->count();
        $response = $total !== 0 ? round(($completed / $total) * 100) . "%" : "0%";
        return $response;
    }

    /**
     * Summary of deadline
     * @return Attribute
     */
    protected function deadline(): Attribute
    {
        return Attribute::make(
            set: fn($value) => Carbon::createFromFormat('m-d-Y', $value),
        );
    }

    /**
     * Summary of client
     * @return BelongsTo<Client, Project>
     */
    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    /**
     * Summary of `vacancy`
     * @return BelongsTo<Vacancy, Project>
     */
    public function vacancy(): BelongsTo
    {
        return $this->belongsTo(Vacancy::class);
    }

    /**
     * Summary of createdBy
     * @return BelongsTo<User, Project>
     */
    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Summary of stages
     * @return HasMany<Stage, Project>
     */
    public function stages(): HasMany
    {
        return $this->hasMany(Stage::class);
    }

    /**
     * Summary of inProgressStage
     * @return HasOne<Stage, Project>
     */
    public function inProgressStage(): HasOne
    {
        return $this->hasOne(Stage::class)->where('status', 'in_progress');
    }

    /**
     * Summary of performers
     * @return BelongsToMany<User, Project> Pivot
     */
    public function performers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'project_user', 'project_id', 'user_id');
    }

    /**
     * Summary of files
     * @return MorphMany<File, Project>
     */
    public function files(): MorphMany
    {
        return $this->morphMany(File::class, 'fileable');
    }

    /**
     * Summary of closeProject
     * @return HasOne<ProjectClosure, Project>
     */
    public function closeProject(): HasOne
    {
        return $this->hasOne(ProjectClosure::class);
    }

    /**
     * Summary of finances
     * @return HasMany<Finance, Project>
     */
    public function finances(): HasMany
    {
        return $this->hasMany(Finance::class);
    }
}
