<?php

namespace App\Contracts;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface BaseRepositoryInterface
{
    /**
     * @return Model
     */
    public function all(): Collection;

    /**
     * @param array $attributes
     * @return Model
     */
    public function create(array $attributes): Model;

    /**
     * @param array $attributes
     * @return bool
     */
    public function insert(array $attributes): bool;

    /**
     * @param int $id
     */
    public function find(int $id);

    /**
     * @param int $id
     * @param array $attributes
     * @return Model
     */
    public function update(int $id, array $attributes): Model;

    /**
     * @param int $id
     */
    public function delete(int $id);

    /**
     * @return Model
     */
    public function first(): Model;

    /**
     * @return Model
     */
    public function getModel(): Model;

    /**
     * @return Model
     */
    public function setModel($model);

    /**
     * @return Builder
     */
    public function newQuery(): Builder;

    /**
     * @param integer $limit
     * @return void
     */
    public function paginate(int $limit = 15);
}
