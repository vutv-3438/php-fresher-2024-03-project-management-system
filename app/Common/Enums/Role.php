<?php

namespace App\Common\Enums;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use ReflectionClass;

class Role
{
    use HasFactory;

    public const MANAGER = 'MANAGER';
    public const MEMBER = 'MEMBER';

    public static function toArray(): array
    {
        $currentClass = new ReflectionClass(self::class);

        return $currentClass->getConstants();
    }
}
