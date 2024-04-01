<?php

namespace App\Common\Enums;

use ReflectionClass;

class Action
{
    public const CREATE = 'create';
    public const UPDATE = 'update';
    public const DELETE = 'delete';
    public const VIEW = 'view';
    public const VIEW_ANY = 'viewAny';
    public const RESTORE = 'restore';
    public const FORCE_DELETE = 'forceDelete';

    public static function toArray(): array
    {
        $currentClass = new ReflectionClass(self::class);

        return $currentClass->getConstants();
    }
}
