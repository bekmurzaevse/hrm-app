<?php

namespace App\Enums\Vacancy;

enum WorkExperienceEnum: string
{
    case NO_EXPERIENCE = 'no_experience';
    case ONE_TO_THREE = 'one_to_three';
    case THREE_TO_SIX = 'three_to_six';
    case OVER_SIX = 'over_six';
}
