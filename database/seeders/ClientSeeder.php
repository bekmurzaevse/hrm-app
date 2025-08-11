<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $client1 = Client::create([
            'name' => 'Google',
            // 'status' => 'Regular',
            'leader' => 'Bill Gates',
            'contact_person' => 'Bazarbay',
            'user_id' => User::inRandomOrder()->first()->id,
            'INN' => '111222333',
            'KPP' => '333222',
            'employee_count' => 25,
            'source' => 'Facebook',
            'city' => 'Moscow',
            'activity' => 'Programming',
            'description' => 'test',
        ]);

        Client::create([
            'name' => 'Tesla',
            // 'status' => 'Regular',
            'leader' => 'Ilon Musk',
            'contact_person' => 'Piyshenbay',
            'user_id' => User::inRandomOrder()->first()->id,
            'INN' => '222333444',
            'KPP' => '666777',
            'employee_count' => 44,
            'source' => 'X',
            'city' => 'Nukus',
            'activity' => 'Design',
            'description' => 'test',
        ]);
    }
}
