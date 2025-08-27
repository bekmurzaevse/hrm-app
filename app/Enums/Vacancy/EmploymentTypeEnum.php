<?php

namespace App\Enums\Vacancy;

enum EmploymentTypeEnum: string
{
    case OFFICE = 'office';
    case REMOTE = 'remote';
    case TEMPORARY = 'temporary';
    case INTERNSHIP = 'internship';
    case HYBRID = 'hybrid';
}
