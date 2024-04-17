<?php

namespace Database\Factories;

use App\Common\Enums\Priority;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class IssueFactory extends Factory
{
    private const DEFAULT_PROJECT_ID = 1;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        $startDate = $this->faker->dateTime;

        return [
            'title' => $this->faker->name,
            'description' => $this->faker->text,
            'start_date' => $startDate,
            'due_date' => Carbon::parse($startDate)->addDay(3),
            'remaining_time' => 5.5,
            'estimated_time' => $this->faker->randomFloat(2, 0, 8),
            'priority' => Priority::MEDIUM,
            'progress' => $this->faker->randomElement([0, 10, 20, 30, 40, 50, 60, 70, 80, 90, 100]),
            'project_id' => self::DEFAULT_PROJECT_ID,
        ];
    }

    public function withProject(int $projectId): IssueFactory
    {
        return $this->state([
            'project_id' => $projectId,
        ]);
    }

    public function withParent(int $parentId): IssueFactory
    {
        return $this->state([
            'parent_issue_id' => $parentId,
        ]);
    }

    public function withAssignee(int $assigneeId): IssueFactory
    {
        return $this->state([
            'assignee_id' => $assigneeId,
        ]);
    }

    public function withIssueType(int $issueTypeId): IssueFactory
    {
        return $this->state([
            'issue_type_id' => $issueTypeId,
        ]);
    }
}
