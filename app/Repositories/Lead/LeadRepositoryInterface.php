<?php


namespace App\Repositories\Lead;


interface LeadRepositoryInterface
{
    public function getById($id);
    public function create($data);
    public function update($data, $id);
    public function delete($id);
}