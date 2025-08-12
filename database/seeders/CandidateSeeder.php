<?php

namespace Database\Seeders;

use App\Helpers\FileUploadHelper;
use App\Models\Candidate;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Http\UploadedFile;

class CandidateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $candidate1 = Candidate::create([
            'first_name' => 'Bill',
            'last_name' => 'Gates',
            'patronymic' => 'bill@example.com',
            'birth_date' => '1994-12-25',
            'gender' => 'male',
            'citizenship' => 'USA',
            'status' => 'New',
            'workplace' => 'Microsoft',
            'position' => 'General Director & Founder',
            'city' => 'California',
            'address' => 'USA California street № 4',
            'salary' => 250000,
            'desired_salary' => 300000,
            'source' => 'Linkedin',
            'experience' => '1-3 year',
            'user_id' => User::inRandomOrder()->first()->id,
        ]);

        $file = UploadedFile::fake()->create('passport.pdf', 1024, 'application/pdf');

        $uploadedFiles = FileUploadHelper::files([$file], "candidates/$candidate1->id");

        array_map(function ($file) use ($candidate1) {
                $candidate1->files()->create($file);
            }, $uploadedFiles);

        $candidate2 = Candidate::create([
            'first_name' => 'Murk',
            'last_name' => 'Zuckerberg',
            'patronymic' => 'murk@example.com',
            'birth_date' => '1960-10-14',
            'gender' => 'male',
            'citizenship' => 'USA',
            'status' => 'New',
            'workplace' => 'META',
            'position' => 'General Director & Founder',
            'city' => 'California',
            'address' => 'USA California street № 15',
            'salary' => 360000,
            'desired_salary' => 450000,
            'source' => 'Linkedin',
            'experience' => '5-7 year',
            'user_id' => User::inRandomOrder()->first()->id,
        ]);

        $file = UploadedFile::fake()->create('Metrika.pdf', 1024, 'application/pdf');

        $uploadedFiles = FileUploadHelper::files([$file], "candidates/$candidate2->id");

        array_map(function ($file) use ($candidate2) {
                $candidate2->files()->create($file);
            }, $uploadedFiles);
    }
}
