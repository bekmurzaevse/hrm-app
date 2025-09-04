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
            $table->foreignId('selection_id')->constrained('selections')->restrictOnDelete()->cascadeOnUpdate();
            $table->foreignId('candidate_id')->constrained('candidates')->restrictOnDelete()->cascadeOnUpdate();
            $table->json('statuses');
            $table->softDeletes();
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
