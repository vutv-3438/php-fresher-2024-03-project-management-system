<?php

namespace App\Common\Enums;

class Status
{
    public const DANGER = 'danger';
    public const SUCCESS = 'success';

    public static function toArray(): array
    {
        return [
            self::SUCCESS,
            self::DANGER,
        ];
    }
}
