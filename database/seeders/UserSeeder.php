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
        $admin1 = User::create([
            'first_name' => 'Pavel',
            'last_name' => 'Durov',
            'patronymic' => 'Vladimirovich',
            'birth_date' => '1996-11-23',
            'address' => 'Astana',
            'position' => 'CEO',
            'status' => 'working',
            'phone' => '1234321',
            'email' => 'pavel@gmail.com',
            'password' => '12345678',
        ]);
        $admin1->assignRole('admin');

        $admin2 = User::create([
            'first_name' => 'Murk',
            'last_name' => 'Zuckerberg',
            'patronymic' => 'test',
            'birth_date' => '1993-04-17',
            'address' => 'Bishkek',
            'position' => 'Leader',
            'status' => 'not_working',
            'phone' => '9878656',
            'email' => 'murk@gmail.com',
            'password' => '12345678',
        ]);
        $admin2->assignRole('admin');

        $manager1 = User::create([
            'first_name' => 'Elon',
            'last_name' => 'Musk',
            'patronymic' => 'Reeve',
            'birth_date' => '1971-06-28',
            'address' => 'Texas, USA',
            'position' => 'Team Leader',
            'status' => 'working',
            'phone' => '998901234567',
            'email' => 'elon.musk@example.com',
            'password' => '12345678',
        ]);
        $manager1->assignRole('manager');

        $manager2 = User::create([
            'first_name' => 'Bill',
            'last_name' => 'Gates',
            'patronymic' => 'Henry',
            'birth_date' => '1955-10-28',
            'address' => 'Seattle, USA',
            'position' => 'Talent Acquisition',
            'status' => 'not_working',
            'phone' => '998935551212',
            'email' => 'bill.gates@example.com',
            'password' => '12345678',
        ]);
        $manager2->assignRole('manager');

        $recruiter1 = User::create([
            'first_name' => 'Jack',
            'last_name' => 'Ma',
            'patronymic' => 'Yun',
            'birth_date' => '1964-09-10',
            'address' => 'Hangzhou, China',
            'position' => 'HR Specialist',
            'status' => 'working',
            'phone' => '998909991010',
            'email' => 'jack.ma@example.com',
            'password' => '12345678',
        ]);
        $recruiter1->assignRole('recruiter');

        $recruiter2 = User::create([
            'first_name' => 'Satya',
            'last_name' => 'Nadella',
            'patronymic' => 'Narayan',
            'birth_date' => '1967-08-19',
            'address' => 'Hyderabad, India',
            'position' => 'Staffing Manager',
            'status' => 'not_working',
            'phone' => '998935552233',
            'email' => 'satya.nadella@example.com',
            'password' => '12345678',
        ]);
        $recruiter2->assignRole('recruiter');

        $recruiter3 = User::create([
            'first_name' => 'Jeff',
            'last_name' => 'Bezos',
            'patronymic' => 'Preston',
            'birth_date' => '1964-01-12',
            'address' => 'New York, USA',
            'position' => 'Staffing Manager',
            'status' => 'dismissed',
            'phone' => '9876543210',
            'email' => 'jeff.bezos@example.com',
            'password' => '12345678',
        ]);
        $recruiter3->assignRole('recruiter');

        $recruiter4 = User::create([
            'first_name' => 'Steve',
            'last_name' => 'Jobs',
            'patronymic' => 'Paul',
            'birth_date' => '1955-02-24',
            'address' => 'Cupertino, USA',
            'position' => 'Staffing Manager',
            'status' => 'working',
            'phone' => '1112223333',
            'email' => 'steve.jobs@example.com',
            'password' => '12345678',
        ]);
        $recruiter4->assignRole('recruiter');
    }
}
