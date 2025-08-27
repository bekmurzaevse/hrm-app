<?php

namespace App\Enums\Client;

enum EmlpoyeeCountEnum: string
{
    //'-50', '50-250', '250+'
    case SMALL = '-50';
    case NORMAL = '50-25-';
    case BIG = '250+';

}
