<?php

namespace Database\Seeders;

use App\Models\Tag;
use App\Models\Vacancy;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Tag::insert([
            [
                'name' => 'HR',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Finance',
                'created_at' => now()->subMinutes(5),
                'updated_at' => now()->subMinutes(5),
            ],
            [
                'name' => 'IT',
                'created_at' => now()->subMinutes(10),
                'updated_at' => now()->subMinutes(10),
            ],
            [
                'name' => 'Marketing',
                'created_at' => now()->subMinutes(15),
                'updated_at' => now()->subMinutes(15),
            ],
            [
                'name' => 'Sales',
                'created_at' => now()->subMinutes(20),
                'updated_at' => now()->subMinutes(20),
            ],
        ]);

        $vacancies = Vacancy::all();
        $tags = Tag::pluck('id')->toArray();

        foreach ($vacancies as $vacancy) {
            $randomTags = collect($tags)->random(rand(1, 3))->toArray();
            $vacancy->tags()->sync($randomTags);
        }

    }
}
