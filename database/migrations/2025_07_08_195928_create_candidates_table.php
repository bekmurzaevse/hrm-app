<?php

use App\Enums\Candidate\CandidateStatusEnum;
use App\Enums\Candidate\FamilyStatusEnum;
use App\Enums\GenderEnum;
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
            $table->date('birth_date');
            $table->string('gender')->default(GenderEnum::MALE->value);
            $table->string('citizenship');
            $table->string('country_residence');
            // $table->foreignId('region_id')->constrained('regions')->restrictOnDelete()->cascadeOnUpdate();
            $table->foreignId('district_id')->constrained('districts')->restrictOnDelete()->cascadeOnUpdate();
            $table->string('address');
            $table->text('family_info')->nullable();
            $table->string('family_status')->default(FamilyStatusEnum::UNMARRIED->value);
            $table->string('status')->default(CandidateStatusEnum::ACTIVE->value);
            $table->string('workplace')->nullable();
            $table->string('position');
            $table->double('desired_salary')->default(0);
            $table->string('source')->nullable();
            $table->foreignId('user_id')->constrained('users')->restrictOnDelete()->cascadeOnUpdate();
            $table->double('experience')->nullable();
            $table->text('short_summary')->nullable();
            $table->text('achievments')->nullable();
            $table->text('comment')->nullable();
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
