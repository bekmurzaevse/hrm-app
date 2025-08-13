<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'first_name' => 'Pavel',
            'last_name' => 'Durov',
            'patronymic' => 'Vladimirovich',
            'position' => 'CEO',
            'status' => 'working',
            'phone' => '1234321',
            'email' => 'pavel@gmail.com',
            'password' => '123',
        ]);

        User::create([
            'first_name' => 'Murk',
            'last_name' => 'Zuckerberg',
            'patronymic' => 'test',
            'position' => 'Director',
            'status' => 'working',
            'phone' => '9878656',
            'email' => 'murk@gmail.com',
            'password' => '123',
        ]);
    }
}
