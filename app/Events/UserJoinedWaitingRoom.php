<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserJoinedWaitingRoom
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $sender;
    public $meeting;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($meeting, $sender)
    {
        $this->meeting = $meeting;
        $this->sender = $sender;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
