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
        Schema::create('selection_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('selection_id')->constrained('selections')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('candidate_id')->nullable()->constrained('candidates')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('external_name')->nullable();

            $table->unique(['selection_id', 'candidate_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('selection_items');
    }
};
