<?php


namespace App\Repositories\Matchmaking;

interface MatchRepositoryInterface
{
    public function getById($id);
    public function create($data);
    public function addItem($match, $item);
    public function update($data, $id);
    public function delete($id);
}