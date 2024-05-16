<?php


namespace App\Repositories\Package;

interface PackageRepositoryInterface
{
    public function getByAgent($agent);

    public function getByPerson($person, $activeOnly = false);

    public function getById($id);

    public function create($data);

    public function update($data, $id);

    public function delete($id);

}