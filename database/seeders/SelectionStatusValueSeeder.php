<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class SelectionStatusValueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // Statuses
        $statuses = [
            1 => [1, 2, 3, 4, 5, 6],
            2 => [7, 8, 9, 10],
            3 => [11, 12, 13, 14],
            4 => [15, 16, 17, 18],
        ];

        // Selection Items
        $selectionItems = [
            ['id' => 1, 'selection_id' => 1],
            ['id' => 2, 'selection_id' => 1],
            ['id' => 3, 'selection_id' => 2],
            ['id' => 4, 'selection_id' => 2],
            ['id' => 5, 'selection_id' => 3],
            ['id' => 6, 'selection_id' => 3],
            ['id' => 7, 'selection_id' => 3],
            ['id' => 8, 'selection_id' => 4],
            ['id' => 9, 'selection_id' => 4],
            ['id' => 10, 'selection_id' => 4],
        ];

        $items = [];

        foreach ($selectionItems as $selectionItem) {
            $selectionItemId = $selectionItem['id'];
            $selectionId = $selectionItem['selection_id'];
            $statusIds = $statuses[$selectionId];

            foreach ($statusIds as $statusId) {
                $items[] = [
                    'selection_item_id' => $selectionItemId,
                    'selection_status_id' => $statusId,
                    'value' => $faker->word(),
                ];
            }
        }

        DB::table('selection_status_values')->insert($items);
    }
}
