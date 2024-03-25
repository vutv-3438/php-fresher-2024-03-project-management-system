<?php

namespace App\Services\Repositories;

use App\Models\LogTime;

class LogTimeRepository extends BaseRepository
{
    public function __construct(LogTime $logTime)
    {
        parent::__construct($logTime);
    }
}
