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

class ContentFieldStored
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $content_field;

    /**
     * Create a new event instance.
     *
     * @param ContentField    $content_field
     * @return void
     */
    public function __construct(ContentField $content_field)
    {
        $this->content_field = $content_field;
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
