<?php

namespace Database\Seeders;

use App\Models\Region;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RegionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Region::insert([
            ['title' => 'Karakalpakstan Republic', 'created_at' => Carbon::now(),],
            ['title' => 'Tashkent', 'created_at' => Carbon::now(),],
            ['title' => 'Tashkent region', 'created_at' => Carbon::now(),],
            ['title' => 'Andijan', 'created_at' => Carbon::now(),],
            ['title' => 'Bukhara', 'created_at' => Carbon::now(),],
            ['title' => 'Fergana', 'created_at' => Carbon::now(),],
            ['title' => 'Jizzakh', 'created_at' => Carbon::now(),],
            ['title' => 'Namangan', 'created_at' => Carbon::now(),],
            ['title' => 'Navoiy', 'created_at' => Carbon::now(),],
            ['title' => 'Kashkadarya', 'created_at' => Carbon::now(),],
            ['title' => 'Samarkand', 'created_at' => Carbon::now(),],
            ['title' => 'Surkhandarya', 'created_at' => Carbon::now(),],
            ['title' => 'Sirdarya', 'created_at' => Carbon::now(),],
            ['title' => 'Khorezm', 'created_at' => Carbon::now(),],
        ]);
    }
}
