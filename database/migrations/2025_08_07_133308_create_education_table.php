<?php

use App\Enums\Candidate\Education\DegreeEnum;
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
        Schema::create('education', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            // $table->string('degree')->nullable();
            $table->string('degree')->default(DegreeEnum::SCHOOL->value)->nullable();
            $table->string('specialty');
            $table->integer('start_year');
            $table->integer('end_year');
            $table->foreignId('candidate_id')->constrained('candidates')->restrictOnDelete()->cascadeOnUpdate();
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
        Schema::dropIfExists('education');
    }
};
