<?php

namespace Thtg88\MmCms\Listeners;

use Illuminate\Support\Str;
use Thtg88\MmCms\Events\ContentModelStored;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class MakeContentModelRepository
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param ContentModelStored $event
     * @return void
     */
    public function handle(ContentModelStored $event)
    {
        $repository_name = Str::studly($event->content_model->name).'Repository';

        \Artisan::call('make:repository', [
            'name' => $repository_name,
        ]);
    }
}
