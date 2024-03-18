<?php

namespace App\Common\Enums;

class Priority
{
    public const HIGHEST = 'Highest';
    public const HIGH = 'High';
    public const MEDIUM = 'Medium';
    public const LOW = 'Low';
    public const LOWEST = 'Lowest';

    public static function toArray(): array
    {
        return [
            self::LOWEST,
            self::LOW,
            self::MEDIUM,
            self::HIGH,
            self::HIGHEST,
        ];
    }
}
