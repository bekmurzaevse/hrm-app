<?php

namespace App\Enums;

enum PeriodEnum: string
{
    case HOUR = 'hour';
    case DAY = 'day';
    case WEEK = 'week';
    case MONTH = 'month';
}
