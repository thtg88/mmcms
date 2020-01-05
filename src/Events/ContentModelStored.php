<?php

namespace Thtg88\MmCms\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Thtg88\MmCms\Models\ContentModel;

class ContentModelStored
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $content_model;

    /**
     * Create a new event instance.
     *
     * @param ContentModel    $content_model
     * @return void
     */
    public function __construct(ContentModel $content_model)
    {
        $this->content_model = $content_model;
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
