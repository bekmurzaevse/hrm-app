<?php

namespace Database\Seeders;

use App\Models\Region;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class RegionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $regions = [
            'Karakalpakstan Republic',
            'Tashkent',
            'Tashkent region',
            'Andijan',
            'Bukhara',
            'Fergana',
            'Jizzakh',
            'Namangan',
            'Navoiy',
            'Kashkadarya',
            'Samarkand',
            'Surkhandarya',
            'Sirdarya',
            'Khorezm',
        ];

        foreach ($regions as $title) {
            Region::create([
                'title' => $title,
            ]);
        }
    }
}
