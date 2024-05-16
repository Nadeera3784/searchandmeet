<?php

namespace App\Repositories\Business;

interface BusinessRepositoryInterface
{
    public function getAll($params);

    public function getById($id);

    public function create($data, $person);

    public function update($data, $id);

    public function delete($id);
}