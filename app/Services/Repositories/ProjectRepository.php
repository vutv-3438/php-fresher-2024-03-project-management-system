<?php

namespace App\Services\Repositories;

use App\Models\Project;
use App\Services\Repositories\Contracts\IProjectRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class ProjectRepository extends BaseRepository implements IProjectRepository
{
    public function __construct(Project $project)
    {
        parent::__construct($project);
    }

    public function create(array $attributes): Project
    {
        return parent::create([
            'name' => $attributes['name'],
            'key' => $attributes['key'],
            'description' => $attributes['description'],
            'start_date' => $attributes['start_date'],
            'end_date' => $attributes['end_date'],
        ]);
    }

    public function update(array $attributes, int $id): bool
    {
        return parent::update([
            'name' => $attributes['name'],
            'key' => $attributes['key'],
            'description' => $attributes['description'],
            'start_date' => $attributes['start_date'],
            'end_date' => $attributes['end_date'],
        ], $id);
    }

    public function getProjectsByUser(int $userId, int $pagigatePerPage = 5): LengthAwarePaginator
    {
        return $this->model->whereHas('roles.users', function ($query) {
            $query->where('users.id', auth()->user()->id);
        })->paginate($pagigatePerPage);
    }
}
