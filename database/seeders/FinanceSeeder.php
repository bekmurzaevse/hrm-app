<?php

namespace Database\Seeders;

use App\Enums\Finance\CategoryExpenseEnum;
use App\Enums\Finance\CategoryIncomeEnum;
use App\Enums\Finance\FinanceTypeEnum;
use App\Models\Finance;
use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class FinanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Finance::create([
            'type' => FinanceTypeEnum::INCOME,
            'category_income' => CategoryIncomeEnum::CLOSE_PROJECT,
            'category_expense' => null,
            'project_id' => Project::inRandomOrder()->first()->id,
            'user_id' => null,
            'date' => Carbon::now()->setMonth(3)->setDay(5),
            'amount' => 12000,
            'comment' => 'CLOSE_PROJECT test',
            'description' => null,
        ]);

        Finance::create([
            'type' => FinanceTypeEnum::INCOME,
            'category_income' => CategoryIncomeEnum::CONSULTATION,
            'category_expense' => null,
            'project_id' => null,
            'user_id' => null,
            'date' => Carbon::now()->setMonth(6)->setDay(10),
            'amount' => 7000,
            'comment' => null,
            'description' => 'CONSULTATION test',
        ]);

        Finance::create([
            'type' => FinanceTypeEnum::INCOME,
            'category_income' => CategoryIncomeEnum::OTHER,
            'category_expense' => null,
            'project_id' => null,
            'user_id' => null,
            'date' => Carbon::now()->setMonth(1)->setDay(12),
            'amount' => 24000,
            'comment' => null,
            'description' => 'OTHER test',
        ]);

        Finance::create([
            'type' => FinanceTypeEnum::EXPENSE,
            'category_income' => null,
            'category_expense' => CategoryExpenseEnum::HONORARIUM,
            'project_id' => Project::inRandomOrder()->first()->id,
            'user_id' => User::inRandomOrder()->first()->id,
            'date' => Carbon::now()->setMonth(1)->setDay(27),
            'amount' => 40000,
            'comment' => 'HONORARIUM test',
            'description' => null,
        ]);

        Finance::create([
            'type' => FinanceTypeEnum::EXPENSE,
            'category_income' => null,
            'category_expense' => CategoryExpenseEnum::AD,
            'project_id' => null,
            'user_id' => null,
            'date' => Carbon::now()->setMonth(8)->setDay(23),
            'amount' => 21000,
            'comment' => 'AD test',
            'description' => null,
        ]);

        Finance::create([
            'type' => FinanceTypeEnum::EXPENSE,
            'category_income' => null,
            'category_expense' => CategoryExpenseEnum::ADMINISTRATIVE,
            'project_id' => null,
            'user_id' => null,
            'date' => Carbon::now()->setMonth(2)->setDay(12),
            'amount' => 32000,
            'comment' => 'ADMINISTRATIVE test',
            'description' => null,
        ]);

        Finance::create([
            'type' => FinanceTypeEnum::EXPENSE,
            'category_income' => null,
            'category_expense' => CategoryExpenseEnum::DIVIDEND,
            'project_id' => null,
            'user_id' => null,
            'date' => Carbon::now()->setMonth(9)->setDay(2),
            'amount' => 32000,
            'comment' => 'DIVIDEND test',
            'description' => null,
        ]);

        Finance::create([
            'type' => FinanceTypeEnum::EXPENSE,
            'category_income' => null,
            'category_expense' => CategoryExpenseEnum::OTHER,
            'project_id' => null,
            'user_id' => null,
            'date' => Carbon::now()->setMonth(6)->setDay(12),
            'amount' => 32000,
            'comment' => 'OTHER test',
            'description' => null,
        ]);
    }
}
