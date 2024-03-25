<?php

namespace App\Services\Repositories;

use App\Models\IssueType;

class IssueTypeRepository extends BaseRepository
{
    public function __construct(IssueType $issueType)
    {
        parent::__construct($issueType);
    }
}
