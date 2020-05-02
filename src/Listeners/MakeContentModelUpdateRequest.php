<?php

namespace Thtg88\MmCms\Listeners;

use Illuminate\Container\Container;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;
use Thtg88\MmCms\Events\ContentModelStored;

class MakeContentModelUpdateRequest
{
    /**
     * Handle the event.
     *
     * @param \Thtg88\MmCms\Events\ContentModelStored $event
     * @return void
     */
    public function handle(ContentModelStored $event): void
    {
        $model_name = Str::studly($event->content_model->name);
        $request_name = $model_name.DIRECTORY_SEPARATOR.'UpdateRequest';

        if (
            file_exists(
                Container::getInstance()
                    ->path('Http/Requests/'.$request_name.'.php')
            )
        ) {
            return;
        }

        Artisan::call('mmcms:make:request', [
            'name' => $model_name,
            '--method' => 'update',
        ]);
    }
}
