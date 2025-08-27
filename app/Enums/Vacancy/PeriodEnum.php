<?php

namespace App\Enums\Vacancy;

enum PeriodEnum: string
{
    case HOUR = 'hour';
    case DAY = 'day';
    case WEEK = 'week';
    case MONTH = 'month';
}
