<?php

namespace App\Imports;

use App\Models\Vacancy;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class VacancyImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new Vacancy([
            'title' => $row['title'],
            'client_id' => $row['client_id'],
            'department' => $row['department'],
            'district_id' => $row['district_id'],
            'type_employment' => $row['type_employment'],
            'work_schedule' => $row['work_schedule'],
            'work_experience' => $row['work_experience'],
            'education' => $row['education'],
            'status' => $row['status'],
            'position_count' => $row['position_count'],
            'created_by' => $row['created_by'],
            'salary_from' => $row['salary_from'],
            'salary_to' => $row['salary_to'],
            'currency' => $row['currency'],
            'period' => $row['period'],
            'bonus' => $row['bonus'],
            'probation' => $row['probation'],
            'probation_salary' => $row['probation_salary'],
            'description' => $row['description'],
            'requirements' => $row['requirements'],
            'responsibilities' => $row['responsibilities'],
            'work_conditions' => $row['work_conditions'],
            'benefits' => $row['benefits'],
        ]);
    }
}