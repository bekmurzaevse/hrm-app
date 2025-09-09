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
        Schema::create('status_values', function (Blueprint $table) {
            $table->id();
            $table->foreignId('selection_item_id')->constrained('selection_items')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('status_id')->constrained('selection_statuses')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('value');

            $table->unique(['selection_item_id', 'status_id'], 'selection_item_status_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('status_values');
    }
};
