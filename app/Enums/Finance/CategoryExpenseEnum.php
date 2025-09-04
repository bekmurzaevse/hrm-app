<?php

namespace App\Enums\Finance;

enum CategoryExpenseEnum: string
{
    case HONORARIUM = 'honorarium';
    case AD = 'ad';
    case ADMINISTRATIVE = 'administrative';
    case DIVIDEND = 'dividend';
    case OTHER = 'other';
}
