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
     * @return void
     */
    public function handle()
    {
        \Artisan::call('migrate', [
            '--force' => true,
        ]);
    }
}
