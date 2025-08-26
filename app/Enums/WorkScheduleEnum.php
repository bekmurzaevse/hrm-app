<?php

namespace App\Enums;

enum WorkScheduleEnum: string
{
    case FULL_TIME = 'full_time';
    case FLEXIBLE = 'flexible';
    case REMOTE = 'remote';
    case SHIFT = 'shift';
}
