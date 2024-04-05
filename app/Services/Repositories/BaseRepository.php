<?php

namespace App\Services\Repositories;

use App\Common\Enums\Action;
use App\Services\Repositories\Contracts\IBaseRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

abstract class BaseRepository implements IBaseRepository
{
    protected $model;

    public function __call($functionName, $arguments)
    {
        if ($functionName === Action::DELETE && count($arguments) === 1) {
            return $this->defineOverloadingDeleteMethod($functionName, $arguments);
        }
    }

    public function defineOverloadingDeleteMethod($functionName, $arguments)
    {
        $argument = $arguments[0];
        if ($argument instanceof Model) {
            return $this->deleteByModel($argument);
        }

        if (is_numeric($argument)) {
            return $this->deleteById($argument);
        }
    }

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function all(): Collection
    {
        return $this->model->all();
    }

    public function find($id): Model
    {
        return $this->model->find($id);
    }

    public function create(array $attributes): Model
    {
        return $this->model->create($attributes);
    }

    public function update(array $attributes, int $id): bool
    {
        return $this->model->findOrFail($id)->update($attributes);
    }

    public function deleteById(int $id): bool
    {
        return $this->model->findOrFail($id)->delete();
    }

    public function deleteByModel(Model $model): bool
    {
        return $model->delete();
    }

    public function findOrFail(int $id): Model
    {
        return $this->model->findOrFail($id);
    }

    public function getAllByProjectId(int $projectId, array $relations = []): Builder
    {
        return $this->model
            ->with($relations)
            ->where('project_id', $projectId);
    }

    public function checkInProject(int $id, int $projectId): bool
    {
        return $this->model
            ->where('id', $id)
            ->where('project_id', $projectId)
            ->exists();
    }
}
