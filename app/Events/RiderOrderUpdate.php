<?php

namespace App\Events;

use App\Models\Order;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class RiderOrderUpdate extends Event implements ShouldBroadcast
{

    use SerializesModels;
    /**
     * Create a new event instance.
     *
     * @return void
     */

    public $order;

    public function __construct(Order $order) {
        $this->order = $order;
    }

    public function broadcastOn()
    {
        return ['orders-'.$this->order->id];
    }

    public function broadcastAs(){
    return 'orders';
    }
}
