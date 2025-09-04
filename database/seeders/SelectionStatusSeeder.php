<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SelectionStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $items = [
            ['selection_id' => 1, 'title' => 'Созвон', 'order' => 1],
            ['selection_id' => 1, 'title' => 'Встреча', 'order' => 2],
            ['selection_id' => 1, 'title' => 'Созвон 2', 'order' => 3],
            ['selection_id' => 1, 'title' => 'Эл.письмо', 'order' => 4],
            ['selection_id' => 1, 'title' => 'Интервью', 'order' => 5],
            ['selection_id' => 1, 'title' => 'Коммент', 'order' => 6],
            ['selection_id' => 2, 'title' => 'Созвон', 'order' => 1],
            ['selection_id' => 2, 'title' => 'Эл.письмо', 'order' => 2],
            ['selection_id' => 2, 'title' => 'Интервью', 'order' => 3],
            ['selection_id' => 2, 'title' => 'Коммент', 'order' => 4],
            ['selection_id' => 3, 'title' => 'Созвон', 'order' => 1],
            ['selection_id' => 3, 'title' => 'Созвон 2', 'order' => 2],
            ['selection_id' => 3, 'title' => 'Эл.письмо', 'order' => 3],
            ['selection_id' => 3, 'title' => 'Коммент', 'order' => 4],
            ['selection_id' => 4, 'title' => 'Созвон', 'order' => 1],
            ['selection_id' => 4, 'title' => 'Созвон 2', 'order' => 2],
            ['selection_id' => 4, 'title' => 'Эл.письмо', 'order' => 3],
            ['selection_id' => 4, 'title' => 'Коммент', 'order' => 4],
        ];

        DB::table('selection_statuses')->insert($items);
    }
}
