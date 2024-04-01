<?php

namespace App\Services\Repositories;

use App\Models\Issue;
use App\Services\Repositories\Contracts\IIssueRepository;
use Illuminate\Database\Eloquent\Model;

class IssueRepository extends BaseRepository implements IIssueRepository
{
    public function __construct(Issue $issue)
    {
        parent::__construct($issue);
    }

    public function create(array $attributes): Model
    {
        return parent::create([
            'title' => $attributes['title'],
            'issue_type_id' => $attributes['issue_type_id'],
            'description' => $attributes['description'],
            'project_id' => $attributes['projectId'],
            'status_id' => $attributes['status_id'],
            'priority' => $attributes['priority'],
            'assignee_id' => $attributes['assignee_id'],
            'parent_issue_id' => $attributes['parent_issue_id'],
            'start_date' => $attributes['start_date'],
            'due_date' => $attributes['due_date'],
            'estimated_time' => $attributes['estimated_time'] ?? 0,
            'progress' => $attributes['progress'],
            'pull_request_link' => $attributes['pull_request_link'],
        ]);
    }

    public function update(array $attributes, int $id): bool
    {
        return parent::update([
            'title' => $attributes['title'],
            'issue_type_id' => $attributes['issue_type_id'],
            'description' => $attributes['description'],
            'project_id' => $attributes['projectId'],
            'status_id' => $attributes['status_id'],
            'priority' => $attributes['priority'],
            'assignee_id' => $attributes['assignee_id'],
            'parent_issue_id' => $attributes['parent_issue_id'],
            'start_date' => $attributes['start_date'],
            'due_date' => $attributes['due_date'],
            'estimated_time' => $attributes['estimated_time'] ?? 0,
            'progress' => $attributes['progress'],
            'pull_request_link' => $attributes['pull_request_link'],
        ], $id);
    }
}
