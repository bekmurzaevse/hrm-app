<?php

namespace Tests\Feature;

use App\Enums\Finance\CategoryExpenseEnum;
use App\Enums\Finance\CategoryIncomeEnum;
use App\Enums\Finance\FinanceTypeEnum;
use App\Models\Finance;
use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class FinanceTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        Storage::fake('public');
        $this->seed();

        $user = User::find(1);
        Sanctum::actingAs($user, ['access-token']);
    }

    /**
     * Summary of test_client_can_get_all
     * @return void
     */
    public function test_finance_can_get_all(): void
    {
        $response = $this->getJson("/api/v1/finances");

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'message',
                'data' => [
                    'card' => [
                        "all_income",
                        "all_expense",
                        "profit",
                    ],
                    'income',
                    'expense',
                    'overview',
                    'items' => [
                        [
                            "type",
                            "category_income",
                            "category_expense",
                            "project_id",
                            "user_id",
                            "date",
                            "amount",
                            "comment",
                            "description"
                        ]
                    ],
                    'pagination' => [
                        'current_page',
                        'per_page',
                        'last_page',
                        'total'
                    ]
                ]
            ]);
    }

    /**
     * Summary of test_finance_income_can_create
     * @return void
     */
    public function test_finance_income_can_create(): void
    {
        $type = FinanceTypeEnum::INCOME->value;
        $categoryIncome = CategoryIncomeEnum::CLOSE_PROJECT->value;
        $projectId = Project::inRandomOrder()->first()->id;
        $date = "2025-01-10";
        $amount = 25000;
        $comment = "Test comment";
        $description = "Test description";

        $data = [
            'type' => $type,
            'category_income' => $categoryIncome,
            'project_id' => $projectId,
            'date' => $date,
            'amount' => $amount,
            'comment' => $comment,
            'description' => $description,
        ];

        $response = $this->postJson('/api/v1/finances/create-income', $data);

        $response->assertStatus(200);

        $this->assertDatabaseHas('finances', [
            'type' => $type,
            'category_income' => $categoryIncome,
            'project_id' => $projectId,
            'amount' => $amount,
            'comment' => $comment,
            'description' => $description,
        ]);
    }

    /**
     * Summary of test_finance_income_can_update
     * @return void
     */
    public function test_finance_income_can_update(): void
    {
        $finance = Finance::where('type', FinanceTypeEnum::INCOME->value)->inRandomOrder()->first();

        $type = FinanceTypeEnum::INCOME->value;
        $categoryIncome = CategoryIncomeEnum::CONSULTATION->value;
        $projectId = Project::inRandomOrder()->first()->id;
        $date = "2025-12-14";
        $amount = 97000;
        $comment = "Test comment new";
        $description = "Test description new";

        $data = [
            'type' => $type,
            'category_income' => $categoryIncome,
            'project_id' => $projectId,
            'date' => $date,
            'amount' => $amount,
            'comment' => $comment,
            'description' => $description,
        ];

        $response = $this->putJson('/api/v1/finances/update-income/' . $finance->id, $data);

        $response
            ->assertStatus(200);

        $this->assertDatabaseHas('finances', [
            'type' => $type,
            'category_income' => $categoryIncome,
            'project_id' => $projectId,
            'amount' => $amount,
            'comment' => $comment,
            'description' => $description,
        ]);
    }

    /**
     * Summary of test_finance_expense_can_create
     * @return void
     */
    public function test_finance_expense_can_create(): void
    {
        $type = FinanceTypeEnum::EXPENSE->value;
        $categoryExpense = CategoryExpenseEnum::ADMINISTRATIVE->value;
        $projectId = Project::inRandomOrder()->first()->id;
        $date = "2025-01-10";
        $amount = 67000;
        $comment = "Test comment";
        $description = "Test description";

        $data = [
            'type' => $type,
            'category_expense' => $categoryExpense,
            'project_id' => $projectId,
            'date' => $date,
            'amount' => $amount,
            'comment' => $comment,
            'description' => $description,
        ];

        $response = $this->postJson('/api/v1/finances/create-expense', $data);

        $response->assertStatus(200);

        $this->assertDatabaseHas('finances', [
            'type' => $type,
            'category_expense' => $categoryExpense,
            'project_id' => $projectId,
            'amount' => $amount,
            'comment' => $comment,
            'description' => $description,
        ]);
    }

    /**
     * Summary of test_finance_expense_can_update
     * @return void
     */
    public function test_finance_expense_can_update(): void
    {
        $finance = Finance::where('type', FinanceTypeEnum::EXPENSE->value)->inRandomOrder()->first();

        $type = FinanceTypeEnum::EXPENSE->value;
        $categoryExpense = CategoryExpenseEnum::HONORARIUM->value;
        $projectId = Project::inRandomOrder()->first()->id;
        $date = "2025-12-14";
        $amount = 97000;
        $comment = "Test comment new";
        $description = "Test description new";

        $data = [
            'type' => $type,
            'category_expense' => $categoryExpense,
            'project_id' => $projectId,
            'date' => $date,
            'amount' => $amount,
            'comment' => $comment,
            'description' => $description,
        ];

        $response = $this->putJson('/api/v1/finances/update-expense/' . $finance->id, $data);

        $response
            ->assertStatus(200);

        $this->assertDatabaseHas('finances', [
            'type' => $type,
            'category_expense' => $categoryExpense,
            'project_id' => $projectId,
            'amount' => $amount,
            'comment' => $comment,
            'description' => $description,
        ]);
    }

    /**
     * Summary of test_finance_can_delete
     * @return void
     */
    public function test_finance_can_delete(): void
    {
        $financeId = Finance::inRandomOrder()->first()->id;

        $response = $this->deleteJson('/api/v1/finances/delete/' . $financeId);

        $response
            ->assertStatus(200);

        $this->assertSoftDeleted('finances', [
            'id' => $financeId,
        ]);
    }
}
