<?php

namespace Database\Seeders;

use App\Models\VacancyDetail;
use Illuminate\Database\Seeder;

class VacancyDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        VacancyDetail::create([
            'vacancy_id' => 1,
            'description' => 'Develop and maintain web applications.',
            'requirements' => 'Bachelor\'s degree in Computer Science or related field. Experience with PHP and Laravel.',
            'responsibilities' => 'Write clean, scalable code. Collaborate with front-end developers and other team members.',
            'work_conditions' => 'Full-time position. Remote work available.',
            'benefits' => 'Health insurance, paid time off, and professional development opportunities.',
        ]);


        VacancyDetail::create([
            'vacancy_id' => 2,
            'description' => 'Manage and oversee the company\'s financial operations.',
            'requirements' => 'Bachelor\'s degree in Finance or Accounting. CPA preferred.',
            'responsibilities' => 'Prepare financial reports, budgets, and forecasts. Ensure compliance with financial regulations.',
            'work_conditions' => 'Full-time position. Office-based with occasional remote work.',
            'benefits' => 'Competitive salary, retirement plan, and health benefits.',
        ]);

        VacancyDetail::create([
            'vacancy_id' => 3,
            'description' => 'Lead the marketing team to develop and implement marketing strategies.',
            'requirements' => 'Bachelor\'s degree in Marketing or Business. Proven experience in a marketing role.',
            'responsibilities' => 'Conduct market research, manage campaigns, and analyze performance metrics.',
            'work_conditions' => 'Full-time position. Hybrid work model available.',
            'benefits' => 'Flexible working hours, health insurance, and professional growth opportunities.',
        ]);
    }
}
