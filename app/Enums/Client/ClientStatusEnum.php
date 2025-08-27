<?php

namespace App\Enums\Client;

enum ClientStatusEnum: string
{
    case ACTIVE = 'Active';
    case POTENTIAL = 'Potential';
    case INACTIVE = 'Inactive';

}
