<?php

namespace App\Repository;

use App\Contracts\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class BaseRepository implements BaseRepositoryInterface
{
    protected Model $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function __call($method, $args)
    {
        return call_user_func_array([$this->model, $method], $args);
    }

    public function all(): Collection
    {
        return $this->model->all();
    }

    public function create(array $attributes): Model
    {
        return $this->model->create($attributes);
    }

    public function insert(array $attributes): bool
    {
        return $this->model->insert($attributes);
    }

    public function find(int $id)
    {
        return $this->model->find($id);
    }

    public function update(int $id, array $attributes): Model
    {
        return tap($this->model->find($id))->update($attributes);
    }

    public function delete(int $id)
    {
        return $this->find($id)->delete();
    }

    public function first(): Model
    {
        return $this->model->first();
    }

    public function getModel(): Model
    {
        return $this->model;
    }

    public function setModel($model)
    {
        $this->model = $model;
        return $this;
    }

    public function newQuery(): Builder
    {
        return $this->model->newQuery();
    }

    public function paginate(int $limit = 15)
    {
        return $this->model->paginate($limit);
    }
}
