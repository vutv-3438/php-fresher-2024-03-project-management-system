<?php

namespace App\Services\Repositories;

use App\Models\Issue;
use App\Services\Repositories\Contracts\IIssueRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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

    public function countIssueWithIssueType(int $projectId)
    {
        return Issue::join('issue_types', 'issues.issue_type_id', '=', 'issue_types.id')
            ->where('issues.project_id', $projectId)
            ->whereNotNull('issues.issue_type_id')
            ->groupBy('issues.issue_type_id')
            ->selectRaw('issue_types.name as label, COUNT(*) as data')
            ->get();
    }

    public function countIssueWithIssueTypeByMember(int $projectId): array
    {
        $issues = Issue::with(['assignee', 'issueType'])
            ->where('project_id', $projectId)
            ->whereNotNull('assignee_id')
            ->whereNotNull('issue_type_id')
            ->select('issue_type_id', 'assignee_id', DB::raw('COUNT(*) as count'))
            ->groupBy('issue_type_id', 'assignee_id')
            ->get();

        $labels = [];
        $datasets = [];

        foreach ($issues as $issue) {
            $userLabel = "{$issue->assignee->full_name} {$issue->assignee->id}";
            if (!in_array($userLabel, $labels)) {
                $labels[] = $userLabel;
            }

            if (!isset($datasets[$issue->issueType->name])) {
                $datasets[$issue->issueType->name] = array_fill(0, count($labels), 0);
            }

            $index = array_search($userLabel, $labels);

            $datasets[$issue->issueType->name][$index] = $issue->count;
        }

        $data = [
            'labels' => $labels,
            'datasets' => [],
        ];

        foreach ($datasets as $issueType => $counts) {
            $data['datasets'][] = [
                'label' => $issueType,
                'data' => $counts,
            ];
        }

        return $data;
    }
}
