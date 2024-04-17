<?php

namespace App\Common\Enums;

use Illuminate\Support\Arr;
use ReflectionClass;

class Resource
{
    public const PROJECT = 'project';
    public const ISSUE = 'issue';
    public const ISSUE_TYPE = 'issue_type';
    public const LOG_TIME = 'log_time';
    public const ROLE = 'role';
    public const ROLE_CLAIM = 'role_claim';
    public const USER = 'user';
    public const USER_ROLE = 'user_role';
    public const WORK_FLOW = 'work_flow';
    public const WORK_FLOW_STEP = 'work_flow_step';
    public const MEMBER = 'member';
    public const REPORT = 'report';

    public static function toArray(): array
    {
        $currentClass = new ReflectionClass(self::class);

        return Arr::except($currentClass->getConstants(), ['USER_ROLE', 'USER']);
    }
}
