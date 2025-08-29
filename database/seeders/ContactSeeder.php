<?php

namespace Database\Seeders;

use App\Models\Candidate;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $candidate = Candidate::inRandomOrder()->first();

        $candidate->contacts()->create([
            'title' => 'phone',
            'value' => '998971234567',
        ]);

        $candidate->contacts()->create([
            'title' => 'email',
            'value' => 'test@gmail.com',
        ]);

        $candidate->contacts()->create([
            'title' => 'Linkedin',
            'value' => 'test@Linkedin.com',
        ]);
    }
}
