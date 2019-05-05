<?php

namespace App\Repositories;

use App\Repositories\RepositoryInterface;

abstract class RepositoryEloquent implements RepositoryInterface
{
	/**
	 * @var string Model name
	 */
	protected $model;

	/**
	 * find or fail
	 * @param  int $id
	 * @return collection
	 */
	public function findOrFail(int $id)
	{
		return $this->model->findOrFail($id);
	}

    public function count()
    {
        return $this->model->count();
    }

	/**
	 * get all
	 * @param  array  $columns
	 * @return collection
	 */
	public function all($columns = ['*'])
	{
		return $this->model->all($columns);
	}

	/**
     * Add a basic where clause to the query.
     *
     * @param  string|array|\Closure  $column
     * @param  mixed   $operator
     * @param  mixed   $value
     * @param  string  $boolean
     * @return $collection
     */
	public function where($column, $operator = null, $value = null, $boolean = 'and')
	{
		return $this->model->where($column, $operator, $value, $boolean);
	}

	/**
	 * create model
	 * @param  array  $data
	 * @return collection
	 */
    public function create(array $data = [])
    {
    	$modal = $this->model->create($data);

        return $modal;
    }

    /**
     * update model
     * @param  array  $data
     * @param  int    $id
     * @return collection
     */
    public function update(array $data = [], int $id)
    {
    	$model = $this->findOrFail($id);
    	$model->update($data);

        return $model;        
    }

    /**
     * destroy model
     * @param  int    $id
     * @return boolean
     */
    public function destroy(int $id)
    {
        try {
            $model = $this->findOrFail($id);
            $model->delete();

            return response()->json(['status' => 'Xóa thành công!']);
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json(['errors' => 'Không thể xóa bản ghi vì vẫn còn người dùng thuộc quyền này!'], 417);
        }
    }

    /**
     * Begin querying a model with eager loading.
     *
     * @param  array|string  $relations
     * @return \Illuminate\Database\Eloquent\Builder|static
     */
    public function with($model)
    {
    	return $this->model->with($model);
    }

    /**
     * Paginate the given query.
     *
     * @param  int  $perPage
     * @param  array  $columns
     * @param  string  $pageName
     * @param  int|null  $page
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     *
     * @throws \InvalidArgumentException
     */
    public function paginate($perPage = null, $columns = ['*'], $pageName = 'page', $page = null)
    {
    	return $this->model->paginate($perPage, $columns, $pageName, $page);
    }

    public function orderBy($column, $direction = 'asc')
    {
        return $this->model->orderBy($column, $direction);
    }
}
