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
        Schema::create('project_vacancy', function (Blueprint $table) {
            $table->id();
            // $table->foreignId('project_id')->constrained('projects')->cascadeOnDelete()->restrictOnUpdate();
            // TODO: Porject Endpoint
            $table->foreignId('vacancy_id')->constrained('vacancies')->cascadeOnDelete()->restrictOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_vacancies');
    }
};
