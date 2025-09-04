<?php

use App\Enums\Finance\FinanceTypeEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('finances', function (Blueprint $table) {
            $table->id();
            $table->string('type')->default(FinanceTypeEnum::INCOME->value);
            $table->string('category_income')->nullable();
            $table->string('category_expense')->nullable();
            $table->foreignId('project_id')->nullable()->constrained('projects')->restrictOnDelete()->cascadeOnUpdate();
            $table->foreignId('user_id')->nullable()->constrained('users')->restrictOnDelete()->cascadeOnUpdate();
            $table->date('date');
            $table->double('amount');
            $table->text('comment')->nullable();
            $table->text('description')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('finances');
    }
};
