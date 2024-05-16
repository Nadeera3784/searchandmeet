<?php


namespace App\Repositories\Meeting;

use App\Enums\Order\OrderStatus;
use App\Models\Meeting;

class MeetingEloquentRepository implements MeetingRepositoryInterface
{
    public function getAll($person = null, $activeOnly = false)
    {
        $meetings = [];
        if($person)
        {
            foreach ($person->orders as $order)
            {
                if ($activeOnly) {
                    if($order->status !== OrderStatus::Cancelled)
                    {
                        foreach ($order->items as $item) {

                            if ($item->meeting) {
                                $item->meeting->initiator = 0;
                                array_push($meetings, $item->meeting);
                            }
                        }
                    }
                }
                else
                {
                    foreach ($order->items as $item) {

                        if ($item->meeting) {
                            $item->meeting->initiator = 0;
                            array_push($meetings, $item->meeting);
                        }
                    }
                }
            }

            foreach ($person->purchase_requirements as $purchase_requirements)
            {
                foreach ($purchase_requirements->orderItems as $item) {
                    if ($activeOnly) {
                        if($item->order->status !== OrderStatus::Cancelled)
                        {
                            if ($item->meeting) {
                                $item->meeting->initiator = 1;
                                array_push($meetings, $item->meeting);
                            }
                        }
                    }
                    else {
                        if ($item->meeting) {
                            $item->meeting->initiator = 1;
                            array_push($meetings, $item->meeting);
                        }
                    }
                }
            }
        }
        else
        {
            return Meeting::all();
        }
        return collect($meetings);
    }

    public function getById($id)
    {
       return Meeting::find($id);
    }

    public function getByOrderItem($item)
    {
        return $item->meeting;
    }

    public function create($data)
    {
        return Meeting::create($data);
    }

    public function update($data, $id)
    {
        $meeting = $this->getById($id);
        return $meeting->update($data);
    }

    public function delete($id)
    {
        $meeting = $this->getById($id);
        return $meeting->delete();
    }
}