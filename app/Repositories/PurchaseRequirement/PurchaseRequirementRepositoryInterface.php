<?php


namespace App\Repositories\PurchaseRequirement;


interface PurchaseRequirementRepositoryInterface
{
    public function getAll($user);
    public function getById($id);
    public function create($data, $person);
    public function update($data, $id);
    public function delete($id);
    public function suffixGenerator();
}