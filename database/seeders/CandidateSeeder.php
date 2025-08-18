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
            'country_residence' => 'Uzbekistan',
            'region' => 'Tashkent',
            'family_status' => 'married',
            'family_info' => 'test test',

            'status' => 'active',
            'workplace' => 'Microsoft',
            'position' => 'General Director & Founder',
            'city' => 'California',
            'address' => 'USA California street № 4',
            // 'salary' => 250000,
            'desired_salary' => 300000,
            'source' => 'Linkedin',
            'experience' => 1,
            'short_summary' => 'test test',
            'achievments' => 'Sport',
            'comment' => 'comments',
            'user_id' => User::inRandomOrder()->first()->id,
        ]);

        $file = UploadedFile::fake()->create('passport.pdf', 1024, 'application/pdf');


        $photo = UploadedFile::fake()->create('test.jpg', 1024, 'image/jpeg');
        $data = FileUploadHelper::file($photo, "test");

        // dd($data);

        $candidate1->photo()->create([
                'name' => $photo->getClientOriginalName(),
                'path' => $data['path'],
                'type' => "photo",
                'size' => $photo->getSize(),
            ]);

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

            'country_residence' => 'Russia',
            'region' => 'Moscow',
            'family_status' => 'unmarried',
            'family_info' => 'test test',

            'status' => 'active',
            'workplace' => 'META',
            'position' => 'General Director & Founder',
            'city' => 'California',
            'address' => 'USA California street № 15',
            // 'salary' => 360000,
            'desired_salary' => 450000,
            'source' => 'Linkedin',
            'experience' => 5,
            'short_summary' => '222 test test',
            'achievments' => '222 Sport',
            'comment' => '222 comments',
            'user_id' => User::inRandomOrder()->first()->id,
        ]);

        $file = UploadedFile::fake()->create('Metrika.pdf', 1024, 'application/pdf');

        $uploadedFiles = FileUploadHelper::files([$file], "candidates/$candidate2->id");

        array_map(function ($file) use ($candidate2) {
                $candidate2->files()->create($file);
            }, $uploadedFiles);
    }
}
