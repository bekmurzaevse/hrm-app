<?php

namespace App\Enums\Vacancy;

enum VacancyStatusEnum: string
{
    case NOT_ACTIVE = 'not_active';
    case OPEN = 'open';
    case CLOSED = 'closed';
    case NOT_CLOSED = 'not_closed';
}
