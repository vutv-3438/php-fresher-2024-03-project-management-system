<?php

namespace App\Common\Enums;

use ReflectionClass;

class Action
{
    public const CREATE = 'create';
    public const UPDATE = 'update';
    public const DELETE = 'delete';

    public static function toArray(): array
    {
        $currentClass = new ReflectionClass(self::class);

        return $currentClass->getConstants();
    }
}
