<?php

namespace App\Common\Enums;

use ReflectionClass;

class Priority
{
    public const HIGHEST = 'Highest';
    public const HIGH = 'High';
    public const MEDIUM = 'Medium';
    public const LOW = 'Low';
    public const LOWEST = 'Lowest';

    public static function toArray(): array
    {
        $currentClass = new ReflectionClass(self::class);

        return $currentClass->getConstants();
    }
}
