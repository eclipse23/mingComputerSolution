<?php

namespace App\Types;

final class RoleType
{
    const ADMINISTRATOR = 'Administrator';
    const CASHIER = 'Cashier';
    const CUSTOMER = 'Customer';

    public static function toArray(): array
    {
        return [
            self::ADMINISTRATOR,
            self::CASHIER,
            self::CUSTOMER,
        ];
    }
}