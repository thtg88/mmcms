<?php

namespace Thtg88\MmCms\Listeners;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;
use Thtg88\MmCms\Events\ContentModelStored;

class MakeContentModelController
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
     * @param \Thtg88\MmCms\Events\ContentModelStored $event
     *
     * @return void
     */
    public function handle(ContentModelStored $event)
    {
        $model_name = Str::studly($event->content_model->name);
        $controller_name = $model_name.'Controller';

        if (class_exists($controller_name)) {
            return;
        }

        Artisan::call('scaffold:bound-controller', [
            'name' => $controller_name,
        ]);
    }
}
