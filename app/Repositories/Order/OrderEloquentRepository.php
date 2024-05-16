<?php


namespace App\Repositories\Order;

use App\Events\OrderCreated;
use App\Models\Order;

class OrderEloquentRepository implements OrderRepositoryInterface
{
    public function getByUser($person)
    {
        $orders = [];
        if($person)
        {
            foreach ($person->orders as $order)
            {
                $order->recieved = false;
                array_push($orders, $order);
            }

            foreach ($person->purchase_requirements as $purchase_requirement)
            {
                foreach ($purchase_requirement->orderItems as $item)
                {
                    $order = $item->order;
                    $order->recieved = true;
                    array_push($orders, $order);
                }
            }
        }
        else
        {
            return Order::all();
        }

        return collect($orders)->paginate();
    }

    public function getById($id)
    {
        return Order::find($id);
    }

    public function create($data)
    {
        $order =  Order::create([
            'person_id' => $data['person_id'],
            'status' => $data['status']
        ]);

        return $order;
    }

    public function addItem($order, $item)
    {
        $item = $order->items()->create([
            'purchase_requirement_id' => $item['purchase_requirement_id'],
            'type' => $item['type'],
            'timeslot_id' => $item['timeslot_id'] ?? null,
            'required_translator' => $item['required_translator'] ?? false,
            'package_id' => $item['package_id'] ?? null,
        ]);

        return $item;
    }

    public function update($data, $id)
    {
        $order = $this->getById($id);
        $order->update($data);
        return $order;
    }

    public function delete($id)
    {
        $order = $this->getById($id);
        foreach ($order->items as $item)
        {
            $item->timeSlot()->delete();
            $item->meeting()->delete();
            $item->delete();
        }

        return $order->delete();
    }
}