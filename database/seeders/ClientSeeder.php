<?php

namespace Database\Seeders;

use App\Helpers\FileUploadHelper;
use App\Models\Client;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Http\UploadedFile;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $client1 = Client::create([
            'name' => 'Google',
            'status' => 'Active',
            'leader' => 'Bill Gates',
            'contact_person' => 'Bazarbay',
            'user_id' => User::inRandomOrder()->first()->id,
            'INN' => '111222333',
            'KPP' => '333222',
            'employee_count' => '-50',
            'source' => 'Facebook',
            'city' => 'Moscow',
            'activity' => 'Programming',
            'description' => 'test',
        ]);

        $client1->contacts()->create([
            'title' => 'phone',
            'value' => '9989074635',
        ]);

        $client1->contacts()->create([
            'title' => 'email',
            'value' => 'email@rmail.com',
        ]);

        $file = UploadedFile::fake()->create('INN.pdf', 1024, 'application/pdf');

        $uploadedFiles = FileUploadHelper::files([$file], "clients/$client1->id");

        array_map(function ($file) use ($client1) {
                $client1->files()->create($file);
            }, $uploadedFiles);

        $client2 = Client::create([
            'name' => 'Tesla',
            'status' => 'Potential',
            'leader' => 'Ilon Musk',
            'contact_person' => 'Piyshenbay',
            'user_id' => User::inRandomOrder()->first()->id,
            'INN' => '222333444',
            'KPP' => '666777',
            'employee_count' => '50-250',
            'source' => 'X',
            'city' => 'Nukus',
            'activity' => 'Design',
            'description' => 'test',
        ]);

        $client2->contacts()->create([
            'title' => 'Linkedin',
            'value' => 'tesla@linkedin',
        ]);

        $client2->contacts()->create([
            'title' => 'telegram',
            'value' => '@tesla_official',
        ]);

        $file = UploadedFile::fake()->create('KPP.pdf', 1024, 'application/pdf');

        $uploadedFiles = FileUploadHelper::files([$file], "clients/$client1->id");

        array_map(function ($file) use ($client2) {
                $client2->files()->create($file);
            }, $uploadedFiles);
    }
}
