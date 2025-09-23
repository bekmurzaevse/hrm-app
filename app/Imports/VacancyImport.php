<?php

namespace App\Imports;

use App\Models\Client;
use App\Models\District;
use App\Models\User;
use App\Models\Vacancy;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class VacancyImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        $clientId = Client::where('name', $row['client_name'])->value('id');
        $districtId = District::where('title', $row['district_title'])->value('id');
        $createdById = User::where('first_name', $row['created_by_name'])->value('id');

        if (
            empty($row['title']) ||
            empty($clientId) ||
            empty($districtId) ||
            empty($createdById) ||
            empty($row['type_employment']) ||
            empty($row['work_schedule']) ||
            empty($row['work_experience']) ||
            empty($row['education']) ||
            empty($row['status']) ||
            empty($row['salary_from']) ||
            empty($row['salary_to']) ||
            empty($row['currency']) ||
            empty($row['period']) ||
            empty($row['description']) ||
            empty($row['requirements']) ||
            empty($row['responsibilities']) ||
            empty($row['work_conditions'])
        ) {
            return null;
        }

        return new Vacancy([
            'title' => $row['title'],
            'client_id' => $clientId,
            'department' => $row['department'] ?? null,
            'district_id' => $districtId,
            'type_employment' => $row['type_employment'],
            'work_schedule' => $row['work_schedule'],
            'work_experience' => $row['work_experience'],
            'education' => $row['education'],
            'status' => $row['status'],
            'position_count' => $row['position_count'] ?? 1,
            'created_by' => $createdById,
            'salary_from' => $row['salary_from'],
            'salary_to' => $row['salary_to'],
            'currency' => $row['currency'],
            'period' => $row['period'],
            'bonus' => $row['bonus'] ?? null,
            'probation' => $row['probation'] ?? null,
            'probation_salary' => $row['probation_salary'] ?? null,
            'description' => $row['description'],
            'requirements' => $row['requirements'],
            'responsibilities' => $row['responsibilities'],
            'work_conditions' => $row['work_conditions'],
            'benefits' => $row['benefits'] ?? null,
        ]);
    }
}