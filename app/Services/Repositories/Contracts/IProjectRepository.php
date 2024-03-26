<?php

namespace App\Services\Repositories\Contracts;

use App\Models\Project;
use Illuminate\Pagination\LengthAwarePaginator;


interface IProjectRepository extends IBaseRepository
{
    public function create(array $attributes): Project;

    public function update(array $attributes, int $id): bool;

    public function getProjectsByUser(int $userId, int $paginatePerPage = 5): LengthAwarePaginator;
}
