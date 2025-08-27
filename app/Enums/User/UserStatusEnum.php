<?php

namespace App\Enums\User;

enum UserStatusEnum: string
{
    case WORKING = 'working';
    case NOT_WORKING = 'not_working';
    case DISMISSED = 'dismissed';

}
