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
        Schema::create('selection_statuses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('selection_id')->constrained('selections')->restrictOnDelete()->cascadeOnUpdate();
            $table->string('title');
            $table->unsignedTinyInteger('order')->default(0);
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('selection_statuses');
    }
};
