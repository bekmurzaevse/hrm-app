<?php

namespace Database\Seeders;

use App\Models\Candidate;
use App\Models\Interaction;
use App\Models\Type;
use App\Models\User;
use Illuminate\Database\Seeder;

class InteractionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Interaction::create([
            'value' => 'phoned',
            'user_id' => User::inRandomOrder()->first()->id,
            'type_id' => Type::inRandomOrder()->first()->id,
            'candidate_id' => Candidate::inRandomOrder()->first()->id,
        ]);

        Interaction::create([
            'value' => 'emailed',
            'user_id' => User::inRandomOrder()->first()->id,
            'type_id' => Type::inRandomOrder()->first()->id,
            'candidate_id' => Candidate::inRandomOrder()->first()->id,
        ]);
    }
}
