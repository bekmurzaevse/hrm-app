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
            ['selection_id' => 1, 'candidate_id' => 1, 'external_name' => null],
            ['selection_id' => 1, 'candidate_id' => 2, 'external_name' => null],
            ['selection_id' => 2, 'candidate_id' => 2, 'external_name' => null],
            ['selection_id' => 2, 'candidate_id' => 1, 'external_name' => null],
            ['selection_id' => 3, 'candidate_id' => 1, 'external_name' => null],
            ['selection_id' => 3, 'candidate_id' => 2, 'external_name' => null],
            ['selection_id' => 3, 'candidate_id' => null, 'external_name' => 'James Harden'],
            ['selection_id' => 4, 'candidate_id' => 1, 'external_name' => null],
            ['selection_id' => 4, 'candidate_id' => null, 'external_name' => 'Loris Paul'],
            ['selection_id' => 4, 'candidate_id' => null, 'external_name' => 'Kevin Durant'],
        ];

        DB::table('selection_items')->insert($items);
    }
}
