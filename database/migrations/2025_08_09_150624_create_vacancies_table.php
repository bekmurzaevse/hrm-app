<?php

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
        Schema::create('vacancies', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->foreignId('client_id')->constrained('clients')->restrictOnDelete()->cascadeOnUpdate();
            $table->float('salary')->default(0)->nullable();
            $table->enum('salary_period', ['month', 'week', 'day', 'hour'])->default('month')->nullable();
            $table->string('city');
            $table->foreignId('user_id')->constrained('users')->restrictOnDelete()->cascadeOnUpdate();
            $table->enum('status', ['in_active', 'open', 'closed', 'not_closed'])->default('open')->nullable();
            $table->enum('type_employment', ['office', 'remote', 'temporary', 'internship'])->default('office')->nullable();
            $table->string('temporary_from')->nullable();
            $table->string('temporary_to')->nullable();
            $table->string('KPI')->nullable();
            $table->string('probation_period')->nullable();
            $table->string('probation_salary')->nullable();
            $table->integer('employee_count');
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
        Schema::dropIfExists('vacancies');
    }
};
