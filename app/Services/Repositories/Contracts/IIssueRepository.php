<?php

namespace App\Services\Repositories\Contracts;

/**
 * @method delete(\App\Models\Issue $issue)
 */
interface IIssueRepository extends IBaseRepository
{
    public function countIssueWithIssueType(int $projectId);

    public function countIssueWithIssueTypeByMember(int $projectId);
}
