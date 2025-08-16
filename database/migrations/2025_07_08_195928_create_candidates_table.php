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
            $table->string('country_residence');
            $table->string('region');
            $table->string('city');
            $table->string('address');
            $table->text('family_info')->nullable();
            $table->enum('family_status', ['married', 'unmarried', 'divorced']);
            $table->enum('status', ['active', 'in_search', 'employed']);
            $table->string('workplace')->nullable();
            $table->string('position');

            // $table->double('salary')->default(0);
            $table->double('desired_salary')->default(0);
            $table->string('source')->nullable();
            $table->foreignId('user_id')->constrained('users')->restrictOnDelete()->cascadeOnUpdate();
            $table->text('experience')->nullable();
            $table->text('about')->nullable();
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
