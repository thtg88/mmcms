<?php

namespace Thtg88\MmCms\Listeners;

use Thtg88\MmCms\Events\ContentModelStored;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class DatabaseMigrate
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
     * @param  ContentModelStored  $event
     * @return void
     */
    public function handle(ContentModelStored $event)
    {
        \Artisan::call('migrate', [
            '--force' => true,
        ]);
    }
}
