<?php

namespace App\Enums\Vacancy;

enum EducationEnum: string
{
    case SECONDARY = 'secondary';
    case SECONDARY_VOCATIONAL = 'secondary_vocational';
    case INCOMPLETE_HIGHER = 'incomplete_higher';
    case HIGHER = 'higher';
}
