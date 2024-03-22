<?php

namespace App\Services\Repositories\Contracts;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface IBaseRepository
{
    public function all(): Collection;

    public function find($id): Model;

    public function create(array $attributes): Model;

    public function update(array $attributes, int $id): bool;
}
