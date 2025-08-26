<?php

namespace App\Enums;

enum StageStatusEnum: string
{
    case COMPLETED = 'completed';
    case IN_PROGRESS = 'in_progress';
    case WAITING = 'waiting';
}