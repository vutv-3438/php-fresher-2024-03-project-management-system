<?php

namespace App\Services\Repositories;

use App\Models\LogTime;

class LogTimeRepository extends BaseRepository
{
    public function __construct(LogTime $project)
    {
        parent::__construct($project);
    }
}
