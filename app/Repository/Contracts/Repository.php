<?php

namespace App\Repository\Contracts;

abstract class Repository implements RepositoryInterface
{

    protected $model;

    public function getModel()
    {
        return $this->model;
    }

    public function all($columns = array('*')): \Illuminate\Support\Collection
    {
        return collect($this->model::get($columns));
    }

    public function paginate($perPage = 15)
    {
        return $this->model::simplePaginate($perPage);
    }

    public function create(array $data)
    {
        return $this->model::insert($data);
    }

    public function delete($id)
    {
        return $this->model::destroy($id);
    }

    public function where($field, $value)
    {
        return $this->model::where($field, '=', $value);
    }

    public function orderBy($field, $order)
    {
        return $this->model::orderBy($field, $order);
    }
}