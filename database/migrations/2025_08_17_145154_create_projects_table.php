<?php

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
            $table->date('deadline');
            $table->string('contract_number')->nullable();
            $table->unsignedInteger('contract_budget')->nullable();
            $table->string('contract_currency')->nullable();
            $table->text('description')->nullable();
            $table->text('comment')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->cascadeOnUpdate()->restrictOnDelete();
            $table->enum('status', ['in_progress', 'cancelled'])->default('in_progress');
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
