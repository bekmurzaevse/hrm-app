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
            $table->string('title');
            $table->foreignId('client_id')->constrained('clients')->restrictOnDelete()->cascadeOnUpdate();
            $table->text('department')->nullable();
            $table->string('city')->nullable();
            $table->enum('type_employment', ['office', 'remote', 'temporary', 'internship', 'hybrid']);
            $table->enum('work_schedule', ['full_time', 'flexible', 'remote', 'shift']);
            $table->enum('work_experience', ['no_experience', 'one_to_three', 'three_to_six', 'over_six']);
            $table->enum('education', ['secondary', 'secondary_vocational', 'incomplete_higher', 'higher']);
            $table->enum('status', ['open', 'in_progress', 'closed', 'paused']);
            $table->enum('priority', ['low', 'medium', 'high']);
            $table->date('deadline');
            $table->foreignId('manager_id')->constrained('users')->restrictOnDelete()->cascadeOnUpdate();
            $table->foreignId('recruiter_id')->constrained('users')->restrictOnDelete()->cascadeOnUpdate();
            $table->foreignId('created_by')->constrained('users')->restrictOnDelete()->cascadeOnUpdate();
            $table->text('comment')->nullable();
            $table->unsignedTinyInteger('position_count')->default(1);
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
