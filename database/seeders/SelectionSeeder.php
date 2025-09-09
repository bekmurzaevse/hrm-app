<?php

namespace Database\Seeders;

use App\Models\Selection;
use Illuminate\Database\Seeder;

class SelectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Selection::create([
            'title' => 'Менеджер по продажам',
            'created_by' => 1
        ]);

        Selection::create([
            'title' => 'Разработчик PHP',
            'created_by' => 1
        ]);

        Selection::create([
            'title' => 'Стажер по маркетингу',
            'created_by' => 5
        ]);

        Selection::create([
            'title' => 'Лидер по маркетингу',
            'created_by' => 5
        ]);

        Selection::create([
            'title' => 'Компанийный менеджер',
            'created_by' => 1
        ]);

        Selection::create([
            'title' => 'Заместитель директора по продажам',
            'created_by' => 1
        ]);
    }
}
