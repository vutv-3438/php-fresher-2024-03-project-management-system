<?php

namespace App\Services\Repositories;

use App\Models\IssueType;

class IssueTypeRepository extends BaseRepository
{
    public function __construct(IssueType $project)
    {
        parent::__construct($project);
    }
}
