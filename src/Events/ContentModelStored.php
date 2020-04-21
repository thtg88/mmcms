<?php

namespace Thtg88\MmCms\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Thtg88\MmCms\Models\ContentModel;

class ContentModelStored
{
    use Dispatchable;

    public $content_model;

    /**
     * Create a new event instance.
     *
     * @param ContentModel $content_model
     * @return void
     */
    public function __construct(ContentModel $content_model)
    {
        $this->content_model = $content_model;
    }
}
