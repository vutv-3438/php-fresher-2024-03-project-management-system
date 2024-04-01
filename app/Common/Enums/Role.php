<?php

namespace App\Common\Enums;

use ReflectionClass;

class Role
{
    public const MANAGER = 'MANAGER';
    public const MEMBER = 'MEMBER';

    public static function toArray(): array
    {
        $currentClass = new ReflectionClass(self::class);

        return $currentClass->getConstants();
    }
}
