<?php


namespace App\Repositories\Person;


interface PersonRepositoryInterface
{
    public function getAll($params);

    public function getByEmail($email);

    public function getById($id);

    public function getDirectLoginLink($id, $redirect = null);

    public function create($data, $agent_id = null, $activate = true);

    public function update($data, $id);

    public function delete($id);
}