<?php

use App\Enums\Vacancy\VacancyStatusEnum;
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
            $table->string('title');
            $table->foreignId('client_id')->constrained('clients')->restrictOnDelete()->cascadeOnUpdate();
            $table->text('department')->nullable();
            $table->foreignId('district_id')->constrained('districts')->restrictOnDelete()->cascadeOnUpdate();
            $table->string('type_employment');
            $table->string('work_schedule');
            $table->string('work_experience');
            $table->string('education');
            $table->string('status')->default(VacancyStatusEnum::NOT_ACTIVE);
            $table->unsignedTinyInteger('position_count')->default(1);
            $table->foreignId('created_by')->constrained('users')->restrictOnDelete()->cascadeOnUpdate();
            $table->unsignedInteger('salary_from');
            $table->unsignedInteger('salary_to');
            $table->string('currency');
            $table->string('period');
            $table->text('bonus')->nullable();
            $table->string('probation')->nullable();
            $table->unsignedInteger('probation_salary')->nullable();
            $table->text('description');
            $table->text('requirements');
            $table->text('responsibilities');
            $table->text('work_conditions');
            $table->text('benefits')->nullable();
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
