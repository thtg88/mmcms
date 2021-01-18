<?php

namespace Thtg88\MmCms\Listeners;

use Illuminate\Support\Facades\Artisan;

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
        Artisan::call('migrate', [
            '--force' => true,
        ]);
    }
}
