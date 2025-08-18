<?php

namespace Database\Seeders;

use App\Models\StageCompletion;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StageCompletionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        StageCompletion::create([
            'stage_id' => 1,
            'candidate_count' => 5,
            'comment' => 'Первичный отбор завершен успешно.',
            'completed_by' => 1,
        ]);

        StageCompletion::create([
            'stage_id' => 6,
            'candidate_count' => 10,
            'comment' => 'Первичный отбор завершен успешно.',
            'completed_by' => 2,
        ]);

        StageCompletion::create([
            'stage_id' => 10,
            'candidate_count' => 4,
            'comment' => 'Первичный отбор завершен успешно.',
            'completed_by' => 1,
        ]);
    }
}
