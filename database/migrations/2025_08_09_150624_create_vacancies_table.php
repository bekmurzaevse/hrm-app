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
        Schema::create('vacancies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained('clients')->restrictOnDelete()->cascadeOnUpdate();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('city');
            $table->enum('type_employment', ['office', 'remote', 'temporary', 'internship'])->default('office')->nullable();
            $table->date('temporary_from')->nullable();
            $table->date('temporary_to')->nullable();
            $table->decimal('salary_min', 10, 2);
            $table->decimal('salary_max', 10, 2);
            $table->enum('salary_period', ['month', 'week', 'day', 'hour']);
            $table->foreignId('created_by')->constrained('users')->restrictOnDelete()->cascadeOnUpdate();
            $table->enum('status', ['in_active', 'open', 'closed', 'not_closed'])->default('in_active');
            // $table->foreignId('skill_id')->constrained('skills')->restrictOnDelete()->cascadeOnUpdate();
            // $table->foreignId('project_id')->constrained('projects')->restrictOnDelete()->cascadeOnUpdate();
            // $table->foreignId('contact_id')->constrained('contacts')->restrictOnDelete()->cascadeOnUpdate();
            $table->unsignedSmallInteger('probation_period_value')->nullable();
            $table->enum('probation_period_unit', ['day', 'days', 'month', 'months'])->nullable();
            $table->decimal('probation_salary_amount', 10, 2)->nullable();
            $table->enum('probation_salary_period', ['hour', 'day', 'week', 'month'])->nullable();
            $table->unsignedTinyInteger('experience_min');
            $table->unsignedTinyInteger('experience_max')->nullable();
            $table->integer('employee_count');
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
