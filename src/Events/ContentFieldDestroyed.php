<?php

namespace Thtg88\MmCms\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Thtg88\MmCms\Models\ContentField;

class ContentFieldDestroyed
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $content_field;
    public $force;

    /**
     * Create a new event instance.
     *
     * @param ContentField $content_field
     * @param boolean $force
     * @return void
     */
    public function __construct(ContentField $content_field, $force = false)
    {
        $this->content_field = $content_field;
        $this->force = $force;
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
