<?php

namespace App\Services\Repositories;

use App\Models\Issue;

class IssueRepository extends BaseRepository
{
    public function __construct(Issue $issue)
    {
        parent::__construct($issue);
    }
}
