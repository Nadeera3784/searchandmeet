<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\ApiController;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Repositories\Meeting\MeetingRepositoryInterface;
use Illuminate\Http\Request;

class OrderController extends ApiController
{
    private $meetingRepository;
    public function __construct(MeetingRepositoryInterface $meetingRepository)
    {
        $this->meetingRepository = $meetingRepository;
    }

    public function search(Request $request){
        $orders = Order::with('items');
        $id = \Hashids::connection(\App\Models\Meeting::class)->decode($request->q)[0] ?? null;
        $orders->where('id', $id);

        return response()->json(OrderResource::collection($orders->get()), 200);
    }
}
