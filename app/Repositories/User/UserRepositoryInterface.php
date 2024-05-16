<?php


namespace App\Repositories\User;


interface UserRepositoryInterface
{
    public function getAll($params);

    public function getById($id);

    public function create($data);

    public function update($data, $id);

    public function delete($id);
}