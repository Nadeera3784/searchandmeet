<?php


namespace App\Repositories\Order;


interface OrderRepositoryInterface
{
    public function getByUser($user);
    public function getById($id);
    public function create($data);
    public function addItem($order, $item);
    public function update($data, $id);
    public function delete($id);
}