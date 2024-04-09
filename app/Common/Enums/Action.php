<?php

namespace App\Common\Enums;

use Illuminate\Support\Arr;
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
    public const LOCK = 'lock';
    public const UNLOCK = 'unlock';
    public const MEANINGS = [
        self::CREATE => 'Create new resource in the current project',
        self::UPDATE => 'Update the specific resource in the current project',
        self::DELETE => 'Delete the specific resource in the current project',
        self::VIEW => 'View the specific resource in the current project',
        self::VIEW_ANY => 'View all resource in the current project',
        self::RESTORE => 'Restore the specific resource in the current project',
        self::FORCE_DELETE => 'Remove forever the specific resource in the current project',
    ];

    public static function toArray(): array
    {
        $currentClass = new ReflectionClass(self::class);

        return Arr::except($currentClass->getConstants(), ['MEANINGS', 'LOCK', 'UNLOCK']);
    }
}
