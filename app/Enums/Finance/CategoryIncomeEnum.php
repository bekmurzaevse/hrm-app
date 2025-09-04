<?php

namespace App\Enums\Finance;

enum CategoryIncomeEnum: string
{
    case CLOSE_PROJECT = 'close_project';
    case CONSULTATION = 'consultation';
    case OTHER = 'other';
}
