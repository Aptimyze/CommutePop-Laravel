<?php

namespace App\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class UserHasRegistered extends Event
{
    use SerializesModels;

    public $name;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->name = $name;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }
}
