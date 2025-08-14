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
        Schema::create('vacancy_salaries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vacancy_id')->constrained('vacancies')->cascadeOnDelete()->restrictOnUpdate();
            $table->unsignedInteger('salary_from');
            $table->unsignedInteger('salary_to');
            $table->enum('curency', ['RUB', 'USD', 'EUR']);
            $table->enum('period', ['hour', 'day', 'week', 'month']);
            $table->text('bonus')->nullable();
            $table->string('probation')->nullable();
            $table->unsignedInteger('probation_salary')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vacancy_details');
    }
};
