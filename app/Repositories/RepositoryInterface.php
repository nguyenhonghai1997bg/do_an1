<?php

namespace App\Repositories;

interface RepositoryInterface
{
    public function all(array $columns);

    public function findOrFail(int $id);

    public function where($column, $operator, $value, $boolean);

    public function create(array $data);

    public function update(array $data, int $id);

    public function destroy(int $id);

    public function with(array $model);

    public function paginate($perPage, $columns, $pageName, $page);
}
