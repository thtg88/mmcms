<?php

namespace Thtg88\MmCms\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Thtg88\MmCms\Models\ContentModel;

class ContentModelStored
{
    use Dispatchable;

    /**
     * The content model model instance.
     *
     * @var \Thtg88\MmCms\Models\ContentModel
     */
    public $content_model;

    /**
     * Create a new event instance.
     *
     * @param \Thtg88\MmCms\Models\ContentModel $content_model
     * @return void
     */
    public function __construct(ContentModel $content_model)
    {
        $this->content_model = $content_model;
    }
}
