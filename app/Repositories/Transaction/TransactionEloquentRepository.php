<?php


namespace App\Repositories\Transaction;


use App\Models\Transaction;

class TransactionEloquentRepository implements TransactionRepositoryInterface
{
    public function getById($transactionId)
    {
        return Transaction::find($transactionId);
    }

    public function getByOrder($order)
    {
        return $order->transaction;
    }

    public function getByPerson($person)
    {
        return $person->transactions;
    }

    public function getByService($service, $reference)
    {
        return Transaction::where('processor', $service)->where('processor_reference', $reference)->first();
    }

    public function create($data, $person)
    {
       return $person->transactions()->create($data);
    }

    public function update($data, $transactionId)
    {
        $transaction = $this->getById($transactionId);
        return $transaction->update($data);
    }

    public function delete($transactionId)
    {
        $transaction = $this->getById($transactionId);
        return $transaction->delete();
    }
}