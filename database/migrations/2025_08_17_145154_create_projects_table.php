<?php

use App\Enums\ProjectStatusEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->foreignId('client_id')->constrained('clients')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('vacancy_id')->constrained('vacancies')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('executor_id')->constrained('users')->cascadeOnUpdate()->restrictOnDelete();
            $table->date('deadline');
            $table->string('contract_number')->nullable();
            $table->unsignedInteger('contract_budget')->nullable();
            $table->string('contract_currency')->nullable();
            $table->text('description')->nullable();
            $table->text('comment')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->cascadeOnUpdate()->restrictOnDelete();
            $table->string('status')->default(ProjectStatusEnum::IN_PROGRESS->value);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
