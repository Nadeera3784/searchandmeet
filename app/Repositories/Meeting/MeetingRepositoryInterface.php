<?php


namespace App\Repositories\Meeting;


interface MeetingRepositoryInterface
{
    public function getAll($person = null, $activeOnly = false);
    public function getById($id);
    public function getByOrderItem($user);
    public function create($data);
    public function update($data, $id);
    public function delete($id);
}