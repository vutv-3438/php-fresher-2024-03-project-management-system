<?php

namespace App\Services\Repositories;

use App\Models\User;
use App\Services\Repositories\Contracts\IUserRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class UserRepository extends BaseRepository implements IUserRepository
{
    public function __construct(User $user)
    {
        parent::__construct($user);
    }

    public function findOrFail(int $id): Model
    {
        return User::withTrashed()->findOrFail($id);
    }

    public function getAllByProjectId(int $projectId, array $relations = []): Builder
    {
        return $this->model
            ->with($relations)
            ->whereHas('roles', function($query) use ($projectId) {
                return $query->where('project_id', $projectId);
            });
    }
}
