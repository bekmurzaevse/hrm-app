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
        Schema::create('adds', function (Blueprint $table) {
            $table->id();
            $table->morphs('addable');
            $table->string('source');
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->date('period_start');
            $table->date('period_end');
            $table->unsignedInteger('budget');
            $table->enum('currency', ['USD', 'EUR', 'RUB']);
            $table->unsignedInteger('views_count')->default(0);
            $table->unsignedInteger('response_count')->default(0);
            $table->foreignId('created_by')->constrained('users')->cascadeOnDelete()->restrictOnUpdate();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('adds');
    }
};
