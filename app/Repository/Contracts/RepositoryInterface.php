<?php

namespace App\Repository\Contracts;

interface RepositoryInterface
{
    public function getModel();
    public function all($columns = array('*'));
    public function paginate($perPage = 15);
    public function create(array $data);
    public function delete($id);
    public function where($field, $value);
    public function orderBy($field, $order);
    public function findBy($field, $value);
}