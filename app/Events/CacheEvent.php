<?php

namespace App\Events;

use App\users;  //调用的model
use App\Http\Controllers\PostController;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class CacheEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $users;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Users $users)
    {
        //将users实例依赖注入
        $this->users = $users;
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
