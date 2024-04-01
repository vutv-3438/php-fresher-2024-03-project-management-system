<?php

namespace App\Common\Enums;

use ReflectionClass;

class Status
{
    public const DANGER = 'danger';
    public const SUCCESS = 'success';

    public static function toArray(): array
    {
        $currentClass = new ReflectionClass(self::class);

        return $currentClass->getConstants();
    }
}
