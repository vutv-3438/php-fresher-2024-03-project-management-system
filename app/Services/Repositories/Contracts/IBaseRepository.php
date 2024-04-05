<?php

namespace App\Services\Repositories\Contracts;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface IBaseRepository
{
    public function all(): Collection;

    public function find($id): Model;

    public function create(array $attributes): Model;

    public function update(array $attributes, int $id): bool;

    public function findOrFail(int $id): Model;

    public function getAllByProjectId(int $projectId, array $relations = []): Builder;

    public function checkInProject(int $id, int $projectId): bool;
}
