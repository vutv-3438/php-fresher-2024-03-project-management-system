<?php

namespace App\Services\Repositories;

use App\Models\IssueType;
use App\Services\Repositories\Contracts\IIssueTypeRepository;
use Illuminate\Database\Eloquent\Model;

class IssueTypeRepository extends BaseRepository implements IIssueTypeRepository
{
    public function __construct(IssueType $issueType)
    {
        parent::__construct($issueType);
    }

    public function create(array $attributes): Model
    {
        return parent::create([
            'name' => $attributes['name'],
            'description' => $attributes['description'],
            'project_id' => $attributes['projectId'],
        ]);
    }

    public function update(array $attributes, int $id): bool
    {
        return parent::update([
            'name' => $attributes['name'],
            'description' => $attributes['description'],
        ], $id);
    }
}
