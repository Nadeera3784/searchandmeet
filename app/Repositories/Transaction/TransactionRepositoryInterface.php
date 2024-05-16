<?php


namespace App\Repositories\Transaction;


interface TransactionRepositoryInterface
{
    public function getById($transactionId);

    public function getByOrder($order);

    public function getByService($service, $reference);

    public function getByPerson($person);

    public function create($data, $person);

    public function update($data, $transactionId);

    public function delete($transactionId);
}