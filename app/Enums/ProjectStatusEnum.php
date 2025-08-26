<?php

namespace App\Enums;

enum ProjectStatusEnum: string
{
    case IN_PROGRESS = 'in_progress';
    case CANCELLED = 'cancelled';
}
