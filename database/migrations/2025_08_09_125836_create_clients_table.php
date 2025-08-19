<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->enum('status', ['Active', 'Potential', 'Inactive'])->default('Active')->nullable();
            $table->string('leader');
            $table->string('contact_person');

            $table->string('person_position');
            $table->string('person_phone');
            $table->string('person_email')->nullable();

            $table->string('phone');
            $table->string('email')->nullable();
            $table->text('address');

            $table->foreignId('user_id')->constrained('users')->restrictOnDelete()->cascadeOnUpdate();
            $table->string('INN')->unique();
            $table->enum('employee_count', ['-50', '50-250', '250+']);
            $table->string('source');
            $table->string('activity')->nullable();
            $table->text('description')->nullable();
            $table->text('notes')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
