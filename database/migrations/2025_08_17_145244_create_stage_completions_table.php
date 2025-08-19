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
        Schema::create('stage_completions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('stage_id')->constrained('stages')->restrictOnDelete()->cascadeOnUpdate();
            $table->unsignedInteger('candidate_count');
            $table->text('comment')->nullable();
            $table->foreignId('completed_by')->constrained('users')->restrictOnDelete()->cascadeOnUpdate();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stage_completions');
    }
};
