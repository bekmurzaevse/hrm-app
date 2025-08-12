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
        Schema::create('candidates', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('patronymic');
            $table->string('birth_date');
            $table->enum('gender', ['male', 'female']);
            $table->string('citizenship');
            // $table->enum('status', ['active', 'in_search', 'conflictfull', 'employed'])->default('active')->nullable();
            $table->enum('status', ['New', 'Connected', 'Interview', 'Suitable', 'Reject'])->default('New')->nullable();
            $table->string('workplace')->nullable();
            $table->string('position');
            $table->string('city');
            $table->string('address');
            $table->double('salary')->default(0);
            $table->double('desired_salary')->default(0);
            $table->string('source')->nullable();
            $table->foreignId('user_id')->constrained('users')->restrictOnDelete()->cascadeOnUpdate();
            $table->text('experience')->nullable();
            $table->text('description')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('candidates');
    }
};
