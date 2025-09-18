<?php

namespace App\Enums\Vacancy;

enum CurrencyEnum: string
{
    case RUB = 'RUB';
    case USD = 'USD';
    case EUR = 'EUR';
    case UZS = 'UZS';

    public function symbol(): string
    {
        return match ($this) {
            self::RUB => '₽',
            self::USD => '$',
            self::EUR => '€',
            self::UZS => 'so‘m',
        };
    }
}
