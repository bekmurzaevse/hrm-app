<?php

namespace App\Models;

use App\Enums\Finance\CategoryExpenseEnum;
use App\Enums\Finance\CategoryIncomeEnum;
use App\Enums\Finance\FinanceTypeEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Finance extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'type',
        'category_income',
        'category_expense',
        'project_id',
        'user_id',
        'date',
        'amount',
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
            'date' => 'date',
            'type' => FinanceTypeEnum::class,
            'category_income' => CategoryIncomeEnum::class,
            'category_expense' => CategoryExpenseEnum::class,
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    /**
     * Summary of project
     * @return BelongsTo<Project, Finance>
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * Summary of project
     * @return BelongsTo<User, Finance>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
