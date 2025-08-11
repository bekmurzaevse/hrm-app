<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\ContactPerson;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ContactPersonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ContactPerson::create([
            'full_name' => ' Test test test',
            'client_id' => Client::inRandomOrder()->first()->id,
            'position' => 'Back end',
            'phone' => '1111111',
            'email' => 'test@test.com',
            'description' => 'test description',
        ]);

        ContactPerson::create([
            'full_name' => ' Pavel Durov',
            'client_id' => Client::inRandomOrder()->first()->id,
            'position' => 'CEO',
            'phone' => '7777777',
            'email' => 'pavel@gmail.com',
            'description' => 'test description',
        ]);
    }
}
