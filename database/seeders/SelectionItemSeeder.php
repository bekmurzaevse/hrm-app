<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SelectionItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $items = [
            ['selection_id' => 1, 'candidate_id' => 1, 'external_name' => null, 'created_at' => now(), 'updated_at' => now()],
            ['selection_id' => 1, 'candidate_id' => 2, 'external_name' => null, 'created_at' => now(), 'updated_at' => now()],
            ['selection_id' => 2, 'candidate_id' => 2, 'external_name' => null, 'created_at' => now(), 'updated_at' => now()],
            ['selection_id' => 2, 'candidate_id' => 1, 'external_name' => null, 'created_at' => now(), 'updated_at' => now()],
            ['selection_id' => 3, 'candidate_id' => 1, 'external_name' => null, 'created_at' => now(), 'updated_at' => now()],
            ['selection_id' => 3, 'candidate_id' => 2, 'external_name' => null, 'created_at' => now(), 'updated_at' => now()],
            ['selection_id' => 3, 'candidate_id' => null, 'external_name' => 'James Harden', 'created_at' => now(), 'updated_at' => now()],
            ['selection_id' => 4, 'candidate_id' => 1, 'external_name' => null, 'created_at' => now(), 'updated_at' => now()],
            ['selection_id' => 4, 'candidate_id' => null, 'external_name' => 'Loris Paul', 'created_at' => now(), 'updated_at' => now()],
            ['selection_id' => 4, 'candidate_id' => null, 'external_name' => 'Kevin Durant', 'created_at' => now(), 'updated_at' => now()],
        ];

        DB::table('selection_items')->insert($items);
    }
}
